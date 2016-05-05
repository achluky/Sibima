<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//output : css folder path
    if ( ! function_exists('css_url')){
      function css_url($uri = ''){
        $CI =& get_instance();
        return base_url()."asset/css/".$uri;
      }
    }

    //output : javascript folder path
    if ( ! function_exists('js_url')){
      function js_url($uri = ''){
        $CI =& get_instance();
        return base_url()."asset/js/".$uri;
      }
    }

    //output : libraries folder path
    if ( ! function_exists('libraries_url')){
      function libraries_url($uri = ''){
        $CI =& get_instance();
        return base_url()."asset/js/plugins/".$uri;
      }
    }

    if(! function_exists('materies_url'))
    {
    	function materies_url($uri = '')
    	{
    		$CI =& get_instance();
    		return base_url()."uploads/materi/".$uri;
    	}
    }

    if(! function_exists('img_url'))
    {
      function img_url($uri = '')
      {
        $CI =& get_instance();
        return base_url()."asset/images/".$uri;
      }
    }