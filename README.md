# Archived 2025-08-02

I switched to using Ghost.

-------------------------------------------

# lambblog

Build and run Docker locally:

```
docker buildx build -t lambblog:latest -f Dockerfile --build-arg AWS_ACCESS_KEY_ID --build-arg AWS_SECRET_ACCESS_KEY  . && docker run -p 80:80 lambblog
```

Markdown static blog generator made with Python

This is a new rewrite of lambblog, which previously was dynamic using PHP, so there are still features missing and lots of things I haven't tested. 

**I cannot really recommend anyone but me using it at this point :)**

## Features

- Valid RSS Feed
- Stage page with some silly metrics
- Mirrors images to S3
- Looks good on mobile
- Support for link posts

## Usage

This is made for my own blog, but if you wanna use it, you can:

- Fork this repo
- Make modifications
- Yada yada 
