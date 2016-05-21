<?php

namespace Robo\Task\Remote;

use Robo\Exception\TaskException;
use Robo\Result;
use Robo\Task\BaseTask;
use Robo\Task\Remote\InputType\FileSizeInterface as FileSize;
use Robo\Task\Remote\InputType\SecondsTime;
use Robo\Task\Remote\InputType\TimeInterface as Time;

/**
 * Uses Wget for non-interactive download of files from the Web.  It supports HTTP, HTTPS, and FTP protocols, as well
 * as retrieval through HTTP proxies.
 *
 * ```php
 * <?php
 *
 * $this->taskWget('http://fly.srk.fer.hr/')
 *      ->recursive()
 *      ->tries(10)
 *      ->outputFile('log')
 *      ->run();
 *
 * ```
 */
class Wget extends BaseTask
{
    use \Robo\Common\ExecOneCommand;

    protected $url;

    public function __construct($url = null)
    {
        $this->url = $url;
    }

    /**
     * Basic Startup Options
     */

    /**
     * @param  string $url
     * @return Wget
     * @throws TaskException
     */
    public function url($url)
    {
        if (!is_string($url)) {
            throw new TaskException($this, 'Url must be a string');
        }

        $this->url = $url;
        return $this;
    }

    /**
     * Execute command as if it were a part of .wgetrc.  A command thus invoked will be executed after the commands in
     * .wgetrc, thus taking precedence over them.  If you need to specify more than one wgetrc command, use multiple
     * instances of -e.
     *
     * @param  string $command
     * @return Wget
     * @throws TaskException
     */
    public function command($command)
    {
        if (!is_string($command)) {
            throw new TaskException($this, 'command must be a string');
        }

        $this->option('-e', $command);

        return $this;
    }

    /**
     * Logging and Input File Options
     */

    /**
     * Log all messages to logfile.  The messages are normally reported to standard error.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function outputFile($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option('-o', $filePath);

        return $this;
    }

    /**
     * Append to logfile.  This is the same as outputFile(), only it appends to logfile instead of overwriting the old
     * log file. If logfile does not exist, a new file is created.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function appendOutput($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option('-a', $filePath);

        return $this;
    }

    /**
     * Turn on debug output, meaning various information important to the developers of Wget if it does not work
     * properly.  Your system administrator may have chosen to compile Wget without debug support, in which case -d
     * will not work.  Please note that compiling with debug support is always safe---Wget compiled with the debug
     * support will not print any debug info unless requested with -d.
     *
     * @return Wget
     */
    public function debug()
    {
        $this->option('-d');

        return $this;
    }

    /**
     * Turn off Wget's output.
     *
     * @return Wget
     */
    public function quiet()
    {
        $this->option('-q');

        return $this;
    }

    /**
     * Turn on verbose output, with all the available data.  The default output is verbose.
     *
     * @return Wget
     */
    public function verbose()
    {
        $this->option('-v');

        return $this;
    }

    /**
     * Turn off verbose without being completely quiet (use -q for that), which means that error messages and basic
     * information still get printed.
     *
     * @return Wget
     */
    public function noVerbose()
    {
        $this->option('-nv');

        return $this;
    }

    /**
     * Output bandwidth as type.  The only accepted value is 'bits'.
     *
     * @return Wget
     */
    public function reportSpeed()
    {
        $this->option('--report-speed=bites');

        return $this;
    }

    /**
     * Read URLs from a local or external file.  If - is specified as file, URLs are read from the standard input.  (Use
     *  ./- to read from a file literally named -.)
     *
     * If this function is used, no URLs need be present on the command line.  If there are URLs both on the command
     * line and in an input file, those on the command lines will be the first ones to be retrieved.  If --force-html
     * is not specified, then file should consist of a series of URLs, one per line.
     *
     * However, if you specify --force-html, the document will be regarded as html.  In that case you may have problems
     * with relative links, which you can solve either by adding "<base href="url">" to the documents or by specifying
     * --base=url on the command line.
     *
     * If the file is an external one, the document will be automatically treated as html if the Content-Type matches
     * text/html. Furthermore, the file's location will be implicitly used as base href if none was specified.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function inputFile($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option('-i', $filePath);

        return $this;
    }

    /**
     * Downloads files covered in local Metalink file. Metalink version 3 and 4 are supported.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function inputMetalink($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option(sprintf('--input-metalink=%s', $filePath));

        return $this;
    }

    /**
     * Issues HTTP HEAD request instead of GET and extracts Metalink metadata from response headers. Then it switches to
     * Metalink download.  If no valid Metalink metadata is found, it falls back to ordinary HTTP download.
     *
     * @return Wget
     */
    public function metalinkOverHttp()
    {
        $this->option('--metalink-over-http');

        return $this;
    }

    /**
     * Set preferred location for Metalink resources. This has effect if multiple resources with same priority are
     * available.
     *
     * @return Wget
     */
    public function preferredLocation()
    {
        $this->option('--preferred-location');

        return $this;
    }

    /**
     * When input is read from a file, force it to be treated as an HTML file.  This enables you to retrieve relative
     * links from existing HTML files on your local disk, by adding "<base href="url">" to HTML, or using the --base
     * command-line option.
     *
     * @return Wget
     */
    public function forceHtml()
    {
        $this->option('-F');

        return $this;
    }

    /**
     * Resolves relative links using URL as the point of reference, when reading links from an HTML file specified via
     * the -i/--input-file option (together with --force-html, or when the input file was fetched remotely from a server
     * describing it as HTML). This is equivalent to the presence of a "BASE" tag in the HTML input file, with URL as
     * the value for the "href" attribute.
     *
     * For instance, if you specify http://foo/bar/a.html for URL, and Wget reads ../baz/b.html from the input file, it
     * would be resolved to http://foo/baz/b.html.
     *
     * @param  string $url
     * @return Wget
     * @throws TaskException
     */
    public function base($url)
    {
        if (!is_string($url)) {
            throw new TaskException($this, 'Url must be a string');
        }

        $this->option('-B', $url);

        return $this;
    }

    /**
     * Specify the location of a startup file you wish to use.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function config($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option(sprintf('--config=%s', $filePath));

        return $this;
    }

    /**
     * Logs all URL rejections to logfile as comma separated values.  The values include the reason of rejection, the
     * URL and the parent URL it was found in.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function rejectedLog($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option(sprintf('--rejected-log=%s', $filePath));

        return $this;
    }

    /**
     * Download Options
     */

    /**
     * When making client TCP/IP connections, bind to ADDRESS on the local machine.  ADDRESS may be specified as a
     * hostname or IP address.  This option can be useful if your machine is bound to multiple IPs.
     *
     * @param  string $address
     * @return Wget
     * @throws TaskException
     */
    public function bindAddress($address)
    {
        if (!is_string($address)) {
            throw new TaskException($this, 'Address must be a string');
        }

        $this->option(sprintf('--bind-address=%s', $address));

        return $this;
    }

    /**
     * Set number of tries to number. Specify 0 or inf for infinite retrying.  The default is to retry 20 times, with
     * the exception of fatal errors like "connection refused" or "not found" (404), which are not retried.
     *
     * @param  int $tries
     * @return Wget
     * @throws TaskException
     */
    public function tries($tries)
    {
        if (!is_int($tries)) {
            throw new TaskException($this, 'tries must be an integer');
        }

        $this->option('-t', $tries);

        return $this;
    }

    /**
     * The documents will not be written to the appropriate files, but all will be concatenated together and written to
     * file.  If - is used as file, documents will be printed to standard output, disabling link conversion.  (Use ./-
     * to print to a file literally named -.)
     *
     * Use of -O is not intended to mean simply "use the name file instead of the one in the URL;" rather, it is
     * analogous to shell redirection: wget -O file http://foo is intended to work like wget -O - http://foo > file;
     * file will be truncated immediately, and all downloaded content will be written there.
     *
     * For this reason, -N (for timestamp-checking) is not supported in combination with -O: since file is always newly
     * created, it will always have a very new timestamp. A warning will be issued if this combination is used.
     *
     * Similarly, using -r or -p with -O may not work as you expect: Wget won't just download the first file to file
     * and then download the rest to their normal names: all downloaded content will be placed in file. This was
     * disabled in version 1.11, but has been reinstated (with a warning) in 1.11.2, as there are some cases where this
     * behavior can actually have some use.
     *
     * A combination with -nc is only accepted if the given output file does not exist.
     *
     * Note that a combination with -k is only permitted when downloading a single document, as in that case it will
     * just convert all relative URIs to external ones; -k makes no sense for multiple URIs when they're all being
     * downloaded to a single file; -k can be used only when the output is a regular file.
     *
     * @param  string $filePath
     * @return Wget
     * @throws TaskException
     */
    public function outputDocument($filePath)
    {
        if (!is_string($filePath)) {
            throw new TaskException($this, 'Filepath must be a string');
        }

        $this->option('-O', $filePath);

        return $this;
    }

    /**
     * If a file is downloaded more than once in the same directory, Wget's behavior depends on a few options, including
     * -nc.  In certain cases, the local file will be clobbered, or overwritten, upon repeated download.  In other cases
     * it will be preserved.
     *
     * When running Wget without -N, -nc, -r, or -p, downloading the same file in the same directory will result in the
     * original copy of file being preserved and the second copy being named file.1.  If that file is downloaded yet
     * again, the third copy will be named file.2, and so on.  (This is also the behavior with -nd, even if -r or -p are
     * in effect.)  When -nc is specified, this behavior is suppressed, and Wget will refuse to download newer copies of
     * file.  Therefore, ""no-clobber"" is actually a misnomer in this mode---it's not clobbering that's prevented (as
     * the numeric suffixes were already preventing clobbering), but rather the multiple version saving that's
     * prevented.
     *
     * When running Wget with -r or -p, but without -N, -nd, or -nc, re-downloading a file will result in the new copy
     * simply overwriting the old.  Adding -nc will prevent this behavior, instead causing the original version to be
     * preserved and any newer copies on the server to be ignored.
     *
     * When running Wget with -N, with or without -r or -p, the decision as to whether or not to download a newer copy
     * of a file depends on the local and remote timestamp and size of the file.  -nc may not be specified at the same
     * time as -N.
     *
     * A combination with -O/--output-document is only accepted if the given output file does not exist.
     *
     * Note that when -nc is specified, files with the suffixes .html or .htm will be loaded from the local disk and
     * parsed as if they had been retrieved from the Web.
     *
     * @return Wget
     */
    public function noClobber()
    {
        $this->option('-nc');

        return $this;
    }

    /**
     * Before (over)writing a file, back up an existing file by adding a .1 suffix (_1 on VMS) to the file name.  Such
     * backup files are rotated to .2, .3, and so on, up to backups (and lost beyond that).
     *
     * @param  int $backups
     * @return Wget
     * @throws TaskException
     */
    public function backups($backups)
    {
        if (!is_int($backups)) {
            throw new TaskException($this, 'Backups must be an integer');
        }

        $this->option(sprintf('--backups=%s', $backups));

        return $this;
    }

    /**
     * Continue / Continuus
     * Used Latin for Continue as continue() is already a function
     *
     * Continue getting a partially-downloaded file.  This is useful when you want to finish up a download started by a
     * previous instance of Wget, or by another program.  For instance:
     *
     * wget -c ftp://sunsite.doc.ic.ac.uk/ls-lR.Z
     *
     * If there is a file named ls-lR.Z in the current directory, Wget will assume that it is the first portion of the
     * remote file, and will ask the server to continue the retrieval from an offset equal to the length of the local
     * file.
     *
     * Note that you don't need to specify this option if you just want the current invocation of Wget to retry
     * downloading a file should the connection be lost midway through.  This is the default behavior.  -c only affects
     * resumption of downloads started prior to this invocation of Wget, and whose local files are still sitting around.
     *
     * Without -c, the previous example would just download the remote file to ls-lR.Z.1, leaving the truncated ls-lR.Z
     * file alone.
     *
     * Beginning with Wget 1.7, if you use -c on a non-empty file, and it turns out that the server does not support
     * continued downloading, Wget will refuse to start the download from scratch, which would effectively ruin existing
     * contents.  If you really want the download to start from scratch, remove the file.
     *
     * Also beginning with Wget 1.7, if you use -c on a file which is of equal size as the one on the server, Wget will
     * refuse to download the file and print an explanatory message.  The same happens when the file is smaller on the
     * server than locally (presumably because it was changed on the server since your last download attempt)---because
     * "continuing" is not meaningful, no download occurs.
     *
     * On the other side of the coin, while using -c, any file that's bigger on the server than locally will be
     * considered an incomplete download and only "(length(remote) - length(local))" bytes will be downloaded and tacked
     * onto the end of the local file.  This behavior can be desirable in certain cases---for instance, you can use
     * wget -c to download just the new portion that's been appended to a data collection or log file.
     *
     * However, if the file is bigger on the server because it's been changed, as opposed to just appended to, you'll
     * end up with a garbled file.  Wget has no way of verifying that the local file is really a valid prefix of the
     * remote file.  You need to be especially careful of this when using -c in conjunction with -r, since every file
     * will be considered as an "incomplete download" candidate.
     *
     * Another instance where you'll get a garbled file if you try to use -c is if you have a lame HTTP proxy that
     * inserts a "transfer interrupted" string into the local file.  In the future a "rollback" option may be added to
     * deal with this case.
     *
     * Note that -c only works with FTP servers and with HTTP servers that support the "Range" header.
     *
     * @return Wget
     */
    public function continuus()
    {
        $this->option('-c');

        return $this;
    }

    /**
     * Start downloading at zero-based position OFFSET.  Offset may be expressed in bytes, kilobytes with the `k'
     * suffix, or megabytes with the `m' suffix, etc.
     *
     * --start-pos has higher precedence over --continue.  When --start-pos and --continue are both specified, wget will
     * emit a warning then proceed as if
     * --continue was absent.
     *
     * Server support for continued download is required, otherwise --start-pos cannot help.  See -c for details.
     *
     * @param  mixed $offset
     * @return Wget
     * @throws TaskException
     */
    public function startPos(FileSize $offset)
    {
        $this->option(sprintf('--rejected-log=%s', $offset->value()));

        return $this;
    }

    /**
     * Select the type of the progress indicator you wish to use.  Legal indicators are "dot" and "bar".
     *
     * The "bar" indicator is used by default.  It draws an ASCII progress bar graphics (a.k.a "thermometer" display)
     * indicating the status of retrieval. If the output is not a TTY, the "dot" bar will be used by default.
     *
     * Use --progress=dot to switch to the "dot" display.  It traces the retrieval by printing dots on the screen, each
     * dot representing a fixed amount of downloaded data.
     *
     * The progress type can also take one or more parameters.  The parameters vary based on the type selected.
     * Parameters to type are passed by appending them to the type sperated by a colon (:) like this:
     * --progress=type:parameter1:parameter2.
     *
     * When using the dotted retrieval, you may set the style by specifying the type as dot:style.  Different styles
     * assign different meaning to one dot. With the "default" style each dot represents 1K, there are ten dots in a
     * cluster and 50 dots in a line.  The "binary" style has a more "computer"-like orientation---8K dots, 16-dots
     * clusters and 48 dots per line (which makes for 384K lines).  The "mega" style is suitable for downloading large
     * files---each dot represents 64K retrieved, there are eight dots in a cluster, and 48 dots on each line (so each
     * line contains 3M). If "mega" is not enough then you can use the "giga" style---each dot represents 1M retrieved,
     * there are eight dots in a cluster, and 32 dots on each line (so each line contains 32M).
     *
     * With --progress=bar, there are currently two possible parameters, force and noscroll.
     *
     * When the output is not a TTY, the progress bar always falls back to "dot", even if --progress=bar was passed to
     * Wget during invokation. This behaviour can be overridden and the "bar" output forced by using the "force"
     * parameter as --progress=bar:force.
     *
     * By default, the bar style progress bar scroll the name of the file from left to right for the file being
     * downloaded if the filename exceeds the maximum length allotted for its display.  In certain cases, such as
     * with --progress=bar:force, one may not want the scrolling filename in the progress bar.  By passing the
     * "noscroll" parameter, Wget can be forced to display as much of the filename as possible without scrolling
     * through it.
     *
     * Note that you can set the default style using the "progress" command in .wgetrc.  That setting may be overridden
     * from the command line.  For example, to force the bar output without scrolling, use
     * --progress=bar:force:noscroll.
     *
     * @param  string $type
     * @return Wget
     * @throws TaskException
     */
    public function progress($type)
    {
        if (!is_string($type)) {
            throw new TaskException($this, 'Type must be a string');
        }

        $this->option(sprintf('--progress=%s', $type));

        return $this;
    }

    /**
     * Force wget to display the progress bar in any verbosity.
     *
     * By default, wget only displays the progress bar in verbose mode.  One may however, want wget to display the
     * progress bar on screen in conjunction with any other verbosity modes like --no-verbose or --quiet.  This is often
     * a desired a property when invoking wget to download several small/large files.  In such a case, wget could simply
     * be invoked with this parameter to get a much cleaner output on the screen.
     *
     * This option will also force the progress bar to be printed to stderr when used alongside the --logfile option.
     *
     * @return Wget
     */
    public function showProgress()
    {
        $this->option('--show-progress');

        return $this;
    }

    /**
     * Turn on time-stamping.
     *
     * @return Wget
     */
    public function timeStamping()
    {
        $this->option('-N');

        return $this;
    }

    /**
     * Do not send If-Modified-Since header in -N mode. Send preliminary HEAD request instead.
     * This has only effect in -N mode.
     *
     * @return Wget
     */
    public function noIfModifiedSince()
    {
        $this->option('--no-if-modified-since');

        return $this;
    }

    /**
     * Don't set the local file's timestamp by the one on the server.
     *
     * By default, when a file is downloaded, its timestamps are set to match those from the remote file. This allows
     * the use of --timestamping on subsequent invocations of wget. However, it is sometimes useful to base the local
     * file's timestamp on when it was actually downloaded; for that purpose, the --no-use-server-timestamps option has
     * been provided.
     *
     * @return Wget
     */
    public function noUseServerTimestamps()
    {
        $this->option('--no-use-server-timestamps');

        return $this;
    }

    /**
     * Print the headers sent by HTTP servers and responses sent by FTP servers.
     *
     * @return Wget
     */
    public function serverResponse()
    {
        $this->option('-S');

        return $this;
    }

    /**
     * When invoked with this option, Wget will behave as a Web spider, which means that it will not download the pages,
     * just check that they are there. For example, you can use Wget to check your bookmarks:
     *
     * wget --spider --force-html -i bookmarks.html
     *
     * This feature needs much more work for Wget to get close to the functionality of real web spiders.
     *
     * @return Wget
     */
    public function spider()
    {
        $this->option('--spider');

        return $this;
    }

    /**
     * Set the network timeout to seconds seconds.  This is equivalent to specifying --dns-timeout, --connect-timeout,
     * and --read-timeout, all at the same time.
     *
     * When interacting with the network, Wget can check for timeout and abort the operation if it takes too long.  This
     * prevents anomalies like hanging reads and infinite connects.  The only timeout enabled by default is a 900-second
     * read timeout.  Setting a timeout to 0 disables it altogether. Unless you know what you are doing, it is best not
     * to change the default timeout settings.
     *
     * All timeout-related options accept decimal values, as well as subsecond values.  For example, 0.1 seconds is a
     * legal (though unwise) choice of timeout.  Subsecond timeouts are useful for checking server response times or for
     * testing network latency.
     *
     * @param  SecondsTime $seconds
     * @return Wget
     * @throws TaskException
     */
    public function timeout(SecondsTime $seconds)
    {
        $this->option('-T', $seconds->value());

        return $this;
    }

    /**
     * Set the DNS lookup timeout to seconds seconds.  DNS lookups that don't complete within the specified time will
     * fail.  By default, there is no timeout on DNS lookups, other than that implemented by system libraries.
     *
     * @param  SecondsTime $seconds
     * @return Wget
     * @throws TaskException
     */
    public function dnsTimeout(SecondsTime $seconds)
    {
        $this->option(sprintf('--dns-timeout=%d', $seconds->value()));

        return $this;
    }

    /**
     * Set the connect timeout to seconds seconds.  TCP connections that take longer to establish will be aborted.  By
     * default, there is no connect timeout, other than that implemented by system libraries.
     *
     * @param  int $seconds
     * @return Wget
     * @throws TaskException
     */
    public function connectTimeout(SecondsTime $seconds)
    {
        $this->option(sprintf('--connect-timeout=%d', $seconds->value()));

        return $this;
    }

    /**
     * Set the read (and write) timeout to seconds seconds.  The "time" of this timeout refers to idle time: if, at any
     * point in the download, no data is received for more than the specified number of seconds, reading fails and the
     * download is restarted.  This option does not directly affect the duration of the entire download.
     *
     * Of course, the remote server may choose to terminate the connection sooner than this option requires.  The
     * default read timeout is 900 seconds.
     *
     * @param  int $seconds
     * @return Wget
     * @throws TaskException
     */
    public function readTimeout(SecondsTime $seconds = null)
    {
        $seconds = $seconds === null ? 900 : $seconds->value();

        $this->option(sprintf('--read-timeout=%d', $seconds));

        return $this;
    }

    /**
     * Limit the download speed to amount bytes per second.  Amount may be expressed in bytes, kilobytes with the k
     * suffix, or megabytes with the m suffix. For example, --limit-rate=20k will limit the retrieval rate to 20KB/s.
     * This is useful when, for whatever reason, you don't want Wget to consume the entire available bandwidth.
     *
     * This option allows the use of decimal numbers, usually in conjunction with power suffixes; for example,
     * --limit-rate=2.5k is a legal value.
     *
     * Note that Wget implements the limiting by sleeping the appropriate amount of time after a network read that took
     * less time than specified by the rate.  Eventually this strategy causes the TCP transfer to slow down to
     * approximately the specified rate.  However, it may take some time for this balance to be achieved, so don't be
     * surprised if limiting the rate doesn't work well with very small files.
     *
     * @param  mixed $ammount
     * @return Wget
     * @throws TaskException
     */
    public function limitRate(FileSize $ammount)
    {
        $this->option(sprintf('--limit-rate=%s', $ammount->value()));

        return $this;
    }

    /**
     * Wait the specified number of seconds between the retrievals.  Use of this option is recommended, as it lightens
     * the server load by making the requests less frequent.  Instead of in seconds, the time can be specified in
     * minutes using the "m" suffix, in hours using "h" suffix, or in days using "d" suffix.
     *
     * Specifying a large value for this option is useful if the network or the destination host is down, so that Wget
     * can wait long enough to reasonably expect the network error to be fixed before the retry.  The waiting interval
     * specified by this function is influenced by "--random-wait", which see.
     *
     * @param  TimeInterface $time
     * @return Wget
     * @throws TaskException
     */
    public function wait(Time $time)
    {
        $this->option('-w', $time->value());

        return $this;
    }

    /**
     * If you don't want Wget to wait between every retrieval, but only between retries of failed downloads, you can use
     * this option.  Wget will use linear backoff, waiting 1 second after the first failure on a given file, then
     * waiting 2 seconds after the second failure on that file, up to the maximum number of seconds you specify.
     *
     * By default, Wget will assume a value of 10 seconds.
     *
     * @param  SecondsTime $seconds
     * @return Wget
     * @throws TaskException
     */
    public function waitRetry(SecondsTime $seconds = null)
    {
        $seconds = $seconds === null ? 10 : $seconds->value();

        $this->option(sprintf('--waitretry=%d', $seconds));

        return $this;
    }

    /**
     * Some web sites may perform log analysis to identify retrieval programs such as Wget by looking for statistically
     * significant similarities in the time between requests. This option causes the time between requests to vary
     * between 0.5 and 1.5 * wait seconds, where wait was specified using the --wait option, in order to mask Wget's
     * presence from such analysis.
     *
     * A 2001 article in a publication devoted to development on a popular consumer platform provided code to perform
     * this analysis on the fly.  Its author suggested blocking at the class C address level to ensure automated
     * retrieval programs were blocked despite changing DHCP-supplied addresses.
     *
     * The --random-wait option was inspired by this ill-advised recommendation to block many unrelated users from a
     * web site due to the actions of one.
     *
     * @return Wget
     */
    public function randomWait()
    {
        $this->option('--random-wait');

        return $this;
    }

    /**
     * Don't use proxies, even if the appropriate *_proxy environment variable is defined.
     *
     * @return Wget
     */
    public function noProxy()
    {
        $this->option('--no-proxy');

        return $this;
    }

    /**
     * Specify download quota for automatic retrievals.  The value can be specified in bytes (default), kilobytes (with
     * k suffix), or megabytes (with m suffix).
     *
     * Note that quota will never affect downloading a single file.  So if you specify wget -Q10k
     * ftp://wuarchive.wustl.edu/ls-lR.gz, all of the ls-lR.gz will be downloaded.  The same goes even when several URLs
     * are specified on the command-line.  However, quota is respected when retrieving either recursively, or from an
     * input file.  Thus you may safely type wget -Q2m -i sites---download will be aborted when the quota is exceeded.
     *
     * Setting quota to 0 or to inf unlimits the download quota.
     *
     * @param  FileSizeInterface $quota
     * @return Wget
     * @throws TaskException
     */
    public function quota(FileSize $quota)
    {
        $this->option(sprintf('--quota=%s', $quota->value()));

        return $this;
    }

    /**
     * Turn off caching of DNS lookups.  Normally, Wget remembers the IP addresses it looked up from DNS so it doesn't
     * have to repeatedly contact the DNS server for the same (typically small) set of hosts it retrieves from.  This
     * cache exists in memory only; a new Wget run will contact DNS again.
     *
     * However, it has been reported that in some situations it is not desirable to cache host names, even for the
     * duration of a short-running application like Wget.  With this option Wget issues a new DNS lookup (more
     * precisely, a new call to "gethostbyname" or "getaddrinfo") each time it makes a new connection.  Please note
     * that this option will not affect caching that might be performed by the resolving library or by an external
     * caching layer, such as NSCD.
     *
     * If you don't understand exactly what this option does, you probably won't need it.
     *
     * @return Wget
     */
    public function noDnsCache()
    {
        $this->option('--no-dns-cache');

        return $this;
    }

    /**
     * Change which characters found in remote URLs must be escaped during generation of local filenames.  Characters
     * that are restricted by this option are escaped, i.e. replaced with %HH, where HH is the hexadecimal number that
     * corresponds to the restricted character. This option may also be used to force all alphabetical cases to be
     * either lower- or uppercase.
     *
     * By default, Wget escapes the characters that are not valid or safe as part of file names on your operating
     * system, as well as control characters that are typically unprintable.  This option is useful for changing these
     * defaults, perhaps because you are downloading to a non-native partition, or because you want to disable escaping
     * of the control characters, or you want to further restrict characters to only those in the ASCII range of values.
     *
     * The modes are a comma-separated set of text values. The acceptable values are unix, windows, nocontrol, ascii,
     * lowercase, and uppercase. The values unix and windows are mutually exclusive (one will override the other), as
     * are lowercase and uppercase. Those last are special cases, as they do not change the set of characters that would
     * be escaped, but rather force local file paths to be converted either to lower- or uppercase.
     *
     * When "unix" is specified, Wget escapes the character / and the control characters in the ranges 0--31 and
     * 128--159.  This is the default on Unix-like operating systems.
     *
     * When "windows" is given, Wget escapes the characters \, |, /, :, ?, ", *, <, >, and the control characters in the
     * ranges 0--31 and 128--159.  In addition to this, Wget in Windows mode uses + instead of : to separate host and
     * port in local file names, and uses @ instead of ? to separate the query portion of the file name from the rest.
     * Therefore, a URL that would be saved as www.xemacs.org:4300/search.pl?input=blah in Unix mode would be saved as
     * www.xemacs.org+4300/search.pl@input=blah in Windows mode.  This mode is the default on Windows.
     *
     * If you specify nocontrol, then the escaping of the control characters is also switched off. This option may make
     * sense when you are downloading URLs whose names contain UTF-8 characters, on a system which can save and display
     * filenames in UTF-8 (some possible byte values used in UTF-8 byte sequences fall in the range of values designated
     * by Wget as "controls").
     *
     * The ascii mode is used to specify that any bytes whose values are outside the range of ASCII characters (that is,
     * greater than 127) shall be escaped. This can be useful when saving filenames whose encoding does not match the
     * one used locally.
     *
     * @param  string $modes
     * @return Wget
     * @throws TaskException
     */
    public function restrictFileNames($modes)
    {
        if (!is_string($modes)) {
            throw new TaskException($this, 'Modes must be a string');
        }

        $this->option(sprintf('--restrict-file-names=%s', $modes));

        return $this;
    }

    /**
     * Force connecting to IPv4 or IPv6 addresses.  With --inet4-only or -4, Wget will only connect to IPv4 hosts,
     * ignoring AAAA records in DNS, and refusing to connect to IPv6 addresses specified in URLs.  Conversely, with
     * --inet6-only or -6, Wget will only connect to IPv6 hosts and ignore A records and IPv4 addresses.
     *
     * Neither options should be needed normally.  By default, an IPv6-aware Wget will use the address family specified
     * by the host's DNS record.  If the DNS responds with both IPv4 and IPv6 addresses, Wget will try them in sequence
     * until it finds one it can connect to.  (Also see "--prefer-family" option described below.)
     *
     * These options can be used to deliberately force the use of IPv4 or IPv6 address families on dual family systems,
     * usually to aid debugging or to deal with broken network configuration.  Only one of --inet6-only and --inet4-only
     * may be specified at the same time.  Neither option is available in Wget compiled without IPv6 support.
     *
     * @return Wget
     */
    public function inet4Only()
    {
        $this->option('-4');

        return $this;
    }

    /**
     * Force connecting to IPv4 or IPv6 addresses.  With --inet4-only or -4, Wget will only connect to IPv4 hosts,
     * ignoring AAAA records in DNS, and refusing to connect to IPv6 addresses specified in URLs.  Conversely, with
     * --inet6-only or -6, Wget will only connect to IPv6 hosts and ignore A records and IPv4 addresses.
     *
     * Neither options should be needed normally.  By default, an IPv6-aware Wget will use the address family specified
     * by the host's DNS record.  If the DNS responds with both IPv4 and IPv6 addresses, Wget will try them in sequence
     * until it finds one it can connect to.  (Also see "--prefer-family" option described below.)
     *
     * These options can be used to deliberately force the use of IPv4 or IPv6 address families on dual family systems,
     * usually to aid debugging or to deal with broken network configuration.  Only one of --inet6-only and --inet4-only
     * may be specified at the same time.  Neither option is available in Wget compiled without IPv6 support.
     *
     * @return Wget
     */
    public function inet6Only()
    {
        $this->option('-6');

        return $this;
    }

    /**
     * When given a choice of several addresses, connect to the addresses with specified address family first.  The
     * address order returned by DNS is used without change by default.
     *
     * This avoids spurious errors and connect attempts when accessing hosts that resolve to both IPv6 and IPv4
     * addresses from IPv4 networks.  For example, www.kame.net resolves to 2001:200:0:8002:203:47ff:fea5:3085 and to
     * 203.178.141.194.  When the preferred family is "IPv4", the IPv4 address is used first; when the preferred family
     * is "IPv6", the IPv6 address is used first; if the specified value is "none", the address order returned by DNS
     * is used without change.
     *
     * Unlike -4 and -6, this option doesn't inhibit access to any address family, it only changes the order in which
     * the addresses are accessed.  Also note that the reordering performed by this option is stable---it doesn't affect
     * order of addresses of the same family.  That is, the relative order of all IPv4 addresses and of all IPv6
     * addresses remains intact in all cases.
     *
     * @param  string $family
     * @return Wget
     * @throws TaskException
     */
    public function preferFamily($family)
    {
        if (!is_string($family)) {
            throw new TaskException($this, 'Family must be a string');
        }

        $this->option(sprintf('--prefer-family=%s', $family));

        return $this;
    }

    /**
     * Consider "connection refused" a transient error and try again.  Normally Wget gives up on a URL when it is unable
     * to connect to the site because failure to connect is taken as a sign that the server is not running at all and
     * that retries would not help.  This option is for mirroring unreliable sites whose servers tend to disappear for
     * short periods of time.
     *
     * @return Wget
     */
    public function retryConnrefused()
    {
        $this->option('--retry-connrefused');

        return $this;
    }

    /**
     * Specify the username user for both FTP and HTTP file retrieval.  This parameter can be overridden using the
     * --ftp-user option for FTP connections and the --http-user option for HTTP connections.
     *
     * @param  string $username
     * @return Wget
     * @throws TaskException
     */
    public function user($username)
    {
        if (!is_string($username)) {
            throw new TaskException($this, 'Username must be a string');
        }

        $this->option(sprintf('--user=%s', $username));

        return $this;
    }

    /**
     * Specify the password for both FTP and HTTP file retrieval.  This parameter can be overridden using the
     * --ftp-password option for FTP connections and the --http-password option for HTTP connections.
     *
     * @param  string $password
     * @return Wget
     * @throws TaskException
     */
    public function password($password)
    {
        if (!is_string($password)) {
            throw new TaskException($this, 'Password must be a string');
        }

        $this->option(sprintf('--password=%s', $password));

        return $this;
    }

    /**
     * Turn off internationalized URI (IRI) support. Use --iri to turn it on. IRI support is activated by default.
     *
     * You can set the default state of IRI support using the "iri" command in .wgetrc. That setting may be overridden
     * from the command line.
     *
     * @return Wget
     */
    public function noIri()
    {
        $this->option('--no-iri');

        return $this;
    }

    /**
     * Force Wget to use encoding as the default system encoding. That affects how Wget converts URLs specified as
     * arguments from locale to UTF-8 for IRI support.
     *
     * Wget use the function "nl_langinfo()" and then the "CHARSET" environment variable to get the locale. If it fails,
     * ASCII is used.
     *
     * You can set the default local encoding using the "local_encoding" command in .wgetrc. That setting may be
     * overridden from the command line.
     *
     * @param  string $encoding
     * @return Wget
     * @throws TaskException
     */
    public function localEncoding($encoding)
    {
        if (!is_string($encoding)) {
            throw new TaskException($this, 'Encoding must be a string');
        }

        $this->option(sprintf('--local-encoding=%s', $encoding));

        return $this;
    }

    /**
     * Force Wget to use encoding as the default remote server encoding.  That affects how Wget converts URIs found in
     * files from remote encoding to UTF-8 during a recursive fetch. This options is only useful for IRI support, for
     * the interpretation of non-ASCII characters.
     *
     * For HTTP, remote encoding can be found in HTTP "Content-Type" header and in HTML "Content-Type http-equiv" meta
     * tag.
     *
     * You can set the default encoding using the "remoteencoding" command in .wgetrc. That setting may be overridden
     * from the command line.
     *
     * @param  string $encoding
     * @return Wget
     * @throws TaskException
     */
    public function remoteEncoding($encoding)
    {
        if (!is_string($encoding)) {
            throw new TaskException($this, 'Encoding must be a string');
        }

        $this->option(sprintf('--remote-encoding=%s', $encoding));

        return $this;
    }

    /**
     * Force Wget to unlink file instead of clobbering existing file. This option is useful for downloading to the
     * directory with hardlinks.
     *
     * @return Wget
     */
    public function unlink()
    {
        $this->option('--unlink');

        return $this;
    }

    // /**
    //  * Directory Options
    //  */

    /**
     * @return \Robo\Result
     */
    public function run()
    {
        $command = $this->getCommand();
        $result = $this->executeCommand($command);

        if (!$result->wasSuccessful()) {
            return $result;
        }

        return Result::success($this);
    }

    public function getCommand()
    {
        $wgetOptions = $this->arguments;
        $url = isset($this->url) ? $this->url : '';

        return trim(
            vsprintf(
                'wget %s%s',
                [$url, $wgetOptions]
            )
        );
    }
}
