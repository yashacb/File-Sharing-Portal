# File-Sharing-Portal
This website can be used to upload files to a local server and create download links for other users to download the uploaded 
files . It also checks the integrity of the uploaded zip files ( using ubuntu's unzip shell command ) .
##Features
..* Each user can create passwod protected zip files so that their data remains safe .
..* Download link is generaed even before the upload process .
..* Uploaded files can be checked for integrity .
..* Users can also search other peoples public uploads .
..* User can view the contents of the zip file even without downloading it so that he can be sure while deleting a zip file from
    his account .
##Usage
To use this file sharing portal on a local area network , cpoy all the files into the server's root . The server should also 
have a mysql database with the username and password mentioned in index.php or login.php , and also an id column .
