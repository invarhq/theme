<?php namespace App\Http\Controllers;

use Layout\Config;
use Layout\Processor\ProcessorHtml;
use Layout\Processor\ProcessorJson;


class LayoutController extends Controller 
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param Config $config
     * @param ProcessorHtml $processor
     * @return mixed
     * @throws \Layout\Processor\ProcessorException
     */
    public function html(Config $config, ProcessorHtml $processor)
    {
        $config->load('layout_index');

        return $processor->run($config);
    }

    /**
     * @param Config $config
     * @param ProcessorJson $processor
     * @return mixed
     * @throws \Layout\Processor\ProcessorException
     */
    public function json(Config $config, ProcessorJson $processor)
    {
        $config->load('layout_index');

        return $processor->run($config);
    }

}
