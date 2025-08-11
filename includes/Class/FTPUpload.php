<?php
class ShahkarFTP {
    private $ftpServer;
    private $ftpPort;
    private $ftpUser;
    private $ftpPassword;
    private $remoteDirectory = "/";

    public function __construct() {
        $this->ftpServer = get_option('Shahkar_Transfer_Ticket_File_To_Ftp_ServerIP');
        $this->ftpUser = get_option('Shahkar_Transfer_Ticket_File_To_Ftp_ServerUsername');
        $this->ftpPassword = get_option('Shahkar_Transfer_Ticket_File_To_Ftp_ServerPassword');
      	$this->ftpPort = get_option('Shahkar_Transfer_Ticket_File_To_Ftp_ServerPort');
    }

    public function uploadFile($fileTempName, $shahkar_filename ,$fileType) {

        $fileSizeBytes = filesize($fileTempName);
        $fileSize = $fileSizeBytes / 1024;



        // Establish FTP connection
        $ftpConnection = ftp_connect($this->ftpServer, $this->ftpPort);
        if (!$ftpConnection) {
            return $this->generateResponse(ShahkarGetTranslateText('ShahkarFileServerNotAvailableResponse'), 'linear-gradient(to right, #ff5f6d, #ffc371)');
        }

        // Login to FTP server
        $loginResult = ftp_login($ftpConnection, $this->ftpUser, $this->ftpPassword);
        if (!$loginResult) {
            ftp_close($ftpConnection);
            return $this->generateResponse(ShahkarGetTranslateText('ShahkarFileServerNotConnectedResponse'), 'linear-gradient(to right, #ff5f6d, #ffc371)');
        }

        // Upload file to FTP server
        $remoteFilePath = $this->remoteDirectory . $shahkar_filename . '.'.$fileType;
        $uploadResult = ftp_put($ftpConnection, $remoteFilePath, $fileTempName, FTP_BINARY);

        // Close FTP connection
        ftp_close($ftpConnection);

        // Check for upload success
        if (!$uploadResult) {
            return $this->generateResponse(ShahkarGetTranslateText('ShahkarFileServerTransferringErrorResponse'), 'linear-gradient(to right, #ff5f6d, #ffc371)');
        }

        return $this->generateResponse(ShahkarGetTranslateText('ShahkarFileServerSuccessfullyUploadResponse'), 'linear-gradient(to right, #00b09b, #96c93d)', $shahkar_filename, 1,1,$fileSize,$fileType);
    }

    private function generateResponse($message, $color, $filename = null, $redirect = null, $FtpStatus = null,$fileSize,$fileType) {
        $response = ['response' => $message, 'color' => $color];
        if ($filename !== null) {
            $response['filename'] = $filename;
        }
        if ($redirect !== null) {
            $response['filetype'] = $fileType;
        }
        if ($redirect !== null) {
            $response['fileSize'] = $fileSize;
        }


        if ($redirect !== null) {
            $response['redirect'] = $redirect;
        }
      
      if ($FtpStatus !== null) {
            $response['FtpStatus'] = $FtpStatus;
        }

        return json_encode($response);
    }
}



?>