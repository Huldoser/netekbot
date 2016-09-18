# Netekbot
Is a Facebook Messenger bot written in PHP that help you to disconnect from your service provider (according to the Israeli law).


### What is it Netekbot?
Translating "Netekbot" from Hebrew means "Disconnection-bot".
According to the Israeli law, a communications service provider must disconnect you from their service up to 72 hours upon request otherwise they will be forced by court to pay you a fee up to 10,000NIS.

This is how Netekbot fits in.
Instead of struggling to formulate a letter, search for contact information, get a fax service, verifying with the service provider it actually received it and then finding out you missed a necessary information and you have to start all over again... what a headache!

Netekbot guides the users through the process according to the service provider they want to leave.
The bot will ask the user for all the needed information, will verify with the user that everything is right and only then it will send an email to the user and the service provider of choice.

### How to make your own Netekbot?
Start by cloning the project.<br />
Review the code and create all the ENVs in your setup.

Register as a Facebook Developer and follow their guidelines how to get started here - https://developers.facebook.com/docs/messenger-platform.

As part of our setup we used the following backend services:<br />
Heroku - Free Dynos.<br />
ClearDB MySql - Ignite.<br />
SendGrid - Starter.<br />

Thus services are not essential for the bot to work but are the easiest & fastest way to get started.

### License
This project have no license.

Everybody is free to clone the project and do whatever you like with the code including but not limited to charging money, rewriting, copying, integrating with existing project and so on.


### Contributors

Andrei Richkov - Project team leader, DevOps, programmer.<br />
Arik Lev Liber - Mentor, supplied the Facebook Messanger integration boilerplate code.<br />
Eran Shimony - Database Interactions, programmer.<br />
Shlomi Saad - Backend logic programmer.<br />
