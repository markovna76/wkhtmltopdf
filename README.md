## wkHtmlToPdf kubernetes service

http://topdf.k8s.ucni/

## Local installation

```console
cd ~/ucni-workspace/
git clone git@github.com:markovna76/wkhtmltopdf.git
cd /srv/www
ln -s ~/ucni-workspace/wkhtmltopdf
ucni restart k8s
```

Wkhtmltopdf is working on a local developer PC as a Docker container ('k8s-topdf') and managed by 'ucni'.

These folders /srv/www/wkhtmltopdf, ~/ucni-workspace/wkhtmltopdf are mounted inside the k8s-topdf container. So you can change some code and see result in real time. Note if you don't have "/srv/www/wkhtmltopdf" link you're using this container in the production mode.

###  Dev. notes:

* You have to restart the k8s container if the files of service/kube have been changed:
- `ucni restart k8s`

* You have to restart the frontend01 container if the file .helm/values.yaml has been changed:
- `ucni restart frontend01`

### Debug
You can see some logs in this container using Docker's commands:
- `docker logs k8s-topdf -f`

### Simple UCNI client:
- https://git.oft-e.com/vehicle-project/mainsite-backend/-/blob/master/app/API/Wkhtmltopdf/Client.php
