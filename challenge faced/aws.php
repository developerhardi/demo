<?php

/*

In one of my codeigniter project, client using AWS EC2 for website hosting and RDS for database. Earlier client was using EC2 instance for image and document uploading and these both occupied more space on instance. So, I provided AWS S3 bucket option to them so all the images and docs space divert to S3 from EC2 and they aggreed on the same. And within 1 day I have completed this AWS S3 bucket integration thing on codeigniter project and then website working fast and also SEO score comes high. 

Here is my code snippet:

bucket_key and bucket_secret_key are load from config file.

*/


use Aws\S3\S3Client;

$s3Client = S3Client::factory(array(
    'credentials' => array(
        'key'    => $this->config->item('bucket_key'),
        'secret' => $this->config->item('bucket_secret_key'),
    )
));
if ($s3Client->doesObjectExist($this->config->item('bucket_name'), $this->config->item('bucket_name') . '/employee/original/' . $existPicActual)) {
    $s3Client->deleteObject([
        'Bucket' => $this->config->item('bucket_name'),
        'Key'    => $this->config->item('bucket_name') . '/employee/original/' . $existPicActual
    ]);
}
if ($s3Client->doesObjectExist($this->config->item('bucket_name'), $this->config->item('bucket_name') . '/employee/thumb/' . $existPicActual)) {
    $s3Client->deleteObject([
        'Bucket' => $this->config->item('bucket_name'),
        'Key'    => $this->config->item('bucket_name') . '/employee/thumb/' . $existPicActual
    ]);
}
$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['profilepost']));
$f = finfo_open();
$mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
$split = explode('/', $mime_type);
$type = $split[1];
$filename = uniqid() . '.' . $type;

$result = $s3Client->putObject([
    'Bucket' => $this->config->item('bucket_name'),
    'Key' => $this->config->item('bucket_name') . '/employee/original/' . basename($filename),
    'Body' => $data,
    'ACL' => 'public-read'
]);
$result1 = $s3Client->putObject([
    'Bucket' => $this->config->item('bucket_name'),
    'Key' => $this->config->item('bucket_name') . '/employee/thumb/' . basename($filename),
    'Body' => $data,
    'ACL' => 'public-read'
]);

?>