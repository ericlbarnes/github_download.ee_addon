<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GitHub Download
 *
 * @package		Plugin
 * @author		Eric Barnes
 * @copyright	Copyright (c) 2010, Eric Barnes
 * @link		http://ericlbarnes.com
 * @purpose		Create a download link from a tag
 */

// ------------------------------------------------------------------------

$plugin_info = array(
	'pi_name'        =>	'Github Download',
	'pi_version'     =>	'1.0.1',
	'pi_author'      =>	'Eric Barnes',
	'pi_author_url'  =>	'http://ericlbarnes.com/',
	'pi_description' =>	'Create a download link from a git tag',
	'pi_usage'       =>	Github_download::usage()

);

// ------------------------------------------------------------------------

class Github_download {

	protected $EE = ''; 
	
	public $return_data = '';
	
	protected $user = '';
	
	protected $repo = '';
	
	protected $tag = 'latest';
	
	protected $type = 'zipball';
	
	protected $class = 'git_download';

	// ------------------------------------------------------------------------
	
	/**
	 * Constructor
	 *
	 * {github_download repo="mycode" tag="latest"}
	 */
	public function Github_download()
	{
		$this->EE =& get_instance();
		
		if ( ! $this->_requirements())
		{
			return 'You must have json_decode';
		}
		
		$this->user = $this->_get_param('user');
		
		$this->repo = $this->_get_param('repo');
		
		$this->tag = $this->_get_param('tag');
		
		$this->type = $this->_get_param('type');
		
		$this->class = $this->_get_param('class');
		
		if ( ! $this->user OR ! $this->repo)
		{
			return 'ERROR NO USER OR REPO GIVEN';
		}
		
		// Yes this is redundant but you never know
		if ($this->type == 'tarball')
		{
			$type = 'tarball';
		}
		else
		{
			$type = 'zipball';
		}
		
		$url = 'http://github.com/'.$this->user.'/'.$this->repo.'/'.$type;
		
		if ($this->tag == 'latest')
		{
			$git_tags = $this->_fetch_tags();
			// Get the latest element
			$tag = array_pop(array_keys($git_tags['tags']));
		}
		else
		{
			$tag = $this->tag;
		}
		
		$this->return_data = '<a class="'.$this->class.'" href="'.$url.'/'.$tag.'">';
		$this->return_data .= $this->EE->TMPL->tagdata;
		$this->return_data .= '</a>';
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Check Server Requirements
	 */
	private function _requirements()
	{
		if ( ! function_exists("json_decode"))
		{
			return FALSE;
		}
		return TRUE;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Helper function for getting a parameter
	 *
	 * @param	string 
	 * @return 	mixed
	 */		 
	private function _get_param($key)
	{
		$val = $this->EE->TMPL->fetch_param($key);

		if ($val == '') 
		{
			return FALSE;
		}
		
		return $val;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Fetch a list of github tags.
	 */
	private function _fetch_tags()
	{
		$responce = $this->_fetch_data('http://github.com/api/v2/json/repos/show/'.$this->user.'/'.$this->repo.'/tags');
		
    	if (empty($responce))
    	{
    		return FALSE;
    	}
    	
    	return $responce;
	}
	// ------------------------------------------------------------------------
	
	
	/**
	 * Fetch the data from GitHub
	 * 
	 * @access	private
	 * @param	string - the API URL to use
	 * @return	object - a decoded JSON object with all the information (FALSE if nothing is returned)
	 */
	private function _fetch_data($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		
		if ($status == '200')
		{
			return json_decode($returned, TRUE);
		} 
		else 
		{
			return FALSE;
		}
	}
	
	// ------------------------------------------------------------------------
	
	
	public function usage()
	{
		ob_start();
?>

{exp:github_download user="github_user" repo="mycode" tag="latest"}

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}
/* End of file pi.github_download.php */
/* Location: ./system/expressionengine/third_party/github_download/pi.github_download.php */ 