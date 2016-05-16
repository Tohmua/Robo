<?php

namespace Robo\Task\Remote;

use Robo\Result;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;

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
