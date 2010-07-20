# GitHub Download for EE

## Installation

Upload the "github_download" folder to your third_party directory. You will need to have a github repo and have tags of your releases for this to work. 

## Usage

This plugin was designed so that you could put a download link directly on your site and not have to send people to github to download it. Another plus is you can use "latest" for the tag and it will automatically update to your latest tag instead of having to manually edit it each time you make a new release. 

	{exp:github_download user="githubusername" repo="reponame" tag="latest"}
	Download
	{/exp:github_download}
	
## Parameters

  * user - Required - Github username
  * repo - Required - Github repo name
  * tag - Required - Lastest or a specific tag. 
  * class - Css class to apply to link
  * type - Either zipball (default) or tarball