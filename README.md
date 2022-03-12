## wkHtmlToPdf kubernetes service

It is a k8s service for make a pdf file from some url.

You should to have the werf for manage this project. See: https://werf.io/

## Local installation

```console
git clone git@github.com:markovna76/wkhtmltopdf.git
cd wkhtmltopdf
```

Wkhtmltopdf is working on a local developer PC as a Docker container and managed by 'werf'.

###  Dev. notes:

* Run on the localPC:
- `werf run html2pdf`

* if you change PHP code, you should to restart container 
