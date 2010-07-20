# GitHub Download for EE

## Installation

Upload the "github_download" folder to your third_party directory. You will need to have a github repo and have tags of your releases for this to work. 

## Usage

	{exp:github_download user="githubusername" repo="reponame" tag="latest"}
	Download
	{/exp:github_download}
	
## Paramaters

  * user - Required - Github username
  * repo - Required - Github repo name
  * tag - Required - Lastest or a specific tag. 
  * class - Css class to apply to link
  * type - Either zipball (default) or tarball