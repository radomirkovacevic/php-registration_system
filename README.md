# php-registration_system
Registration system that require account activation trough mail link.
This project is for portfolio purpose, also for my own projects and will be continuously developed. Project is done in php, mysql, basic html and css(can be easly applied to other projects).

(1)Registration require inputs as first name(1.1), last name(1.2), email(1.3) and password (1.4)
-registration proccess is divided in two files (registration.php for user inputs and reg_users.php for backend proccess)
-if proccess is successful key being created, inserted in base and sended to user trough email sender
(reg_user.php line 121 function createLink() and line 156 function mailKey())

1.1 & 1.2 
-require english letters and doesn't accept numbers or special caharcters (reg_user.php line 80 function nameValid())
-doesn't matter if letters are uppercase or lowercase because function convert each input with first letter 
uppercase and rest as lowercase (reg_user.php line 39 function firstletterUpcase() and line 189-191 directly)

1.3
-emals in base aren't unique, that does script (reg_user.php line 93 function checkUserMail()) based on email and status
-php function check if mail from input is valid (reg_user.php line 65 function mailValid())
-doesn't matter if letters are uppercase or lowercase because function convert input as lowecase

1.4
-password is first thing that goes checked, input must have over 4 characters
-password is hashed for test purposes by sha1 and base has diferent charset (utf8 unicode) to 
make sure it do diference between characters

(2)Login require inputs as email(2.1) and password(2.2)
-login process is divided in two files (login.php for users input and login_users.php for backend process)
-mail, password and predefined status are checked trough sql string(login_user.php line 38 function checkUser())
-status is defined as 1 (line 32 in function checkUser())
-user informations id, first name, last name, user mail and date are stored in session array(login_user.php line 47 and line 51 in function checkUser())

(3)Logout is awaken by link(cpanel.php line 32)
-logout script has session destroy method and header with navigation to root(index.php by default)

(4)Index page has 2(login and cpanel) links and index page can be seen only by users who logedin

(5)Cpanel page will be used for users and devided by ranks(in future)
-cpanel has information about loged user from session called "activated_user" with informations as
id, first name, last name, user mail and date
-link with navigation to logout file(users/logout.php)

(6)Activate is backend page
-used to reach key details from mail link(activate.php line 21 function activation())
-getting link details starts on end of file and out of class(line 46 and 47)



