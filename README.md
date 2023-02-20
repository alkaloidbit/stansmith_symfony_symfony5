version: 1.2

# How to use:

cd to root_dir, then `syse`

`yarn dev-server-local --hot`

# Admin Side

cd to root_dir/my-admin, then `yarn start`

# Handling File Upload

https://api-platform.com/docs/core/file-upload/

- [x] Test making a post request to the /media_objects endpoint 

After posting the data we receive a response like that:

```json
{
	"@type": "https://shema.org/MediaObject",
	"@id": "/media_objects/<id>",
	"contentUrl": "<url>"
}
```


