This is my first api where we can create user, view all users, view single user, update the records of the user and delete the user from the database.


For using the api,
First of all, create a new mysql database named "_firstapi_" in your phpmyadmin.
Then run the command php config/migrate.php.

After that users table will be created in the database.

Now use the url 'localhost/Src/create.php' for creating the new user.
The method is post method.
The required json data sample is: 


{
    "username":"sangamm",
    "email":"sangam@gmail.com",
    "password":"helloWorld",
    "fullname":"Sangam Poudel",
    "address" : "Pokhara",
    "phone_number": "9812356488"
}

Similarly for viewing all the users, the url is: 'localhost/Src/viewAllUsers.php'.

Similarly for viewing a particular the user with user id 1, the url is: 'localhost/Src/viewOneUser.php?user_id=1'

For updating the details of user with id 1, the url is 'localhost/Src/updateUser.php'.
Method is post.
Required json data sample is:


{
    "id: 1,
    "username":"its.sangam",
    "email":"sangam@gmail.com",
    "password":"helloWorld",
    "fullname":"Sangam Poudel",
    "address" : "Kathmandu",
    "phone_number": "9812356488"
}

Similarly for deleting the user with id 1 , the url is: 'localhost/Src/deleteUser.php'
Method is post.
Required JSON data sample is:

{
  "id":1
}




