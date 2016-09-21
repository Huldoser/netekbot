# Netekbot
Netekbot is a Facebook Messenger bot written in PHP that helps you to disconnect from your service provider (according to the Israeli law).


### What is it Netekbot?
Translating "Netekbot" from Hebrew means "Disconnection-bot".
According to the Israeli law, any communications service provider must disconnect you from their service up to 72 hours upon request otherwise they may be forced by court to pay you a fee up to 10,000NIS.

This is how Netekbot fit in.
Instead of struggling to formulate a letter, search for contact information, get a fax service, verifying with the service provider it actually received it and then finding out you missed a necessary information and you have to start all over again... what a headache!

Netekbot guides the users through the process according to the service provider they want to disconnect from.
The bot will ask the user for all the needed information, will verify with the user that everything is right and only then it will send an email to both, the user and the service provider of choice.

### How to make your own Netekbot?
Start by cloning the project.<br />
Review the code and create all the ENVs, which can be found in app/netekbot/config.class.php file.

Register as a Facebook Developer and follow their guidelines about how to get started here - https://developers.facebook.com/docs/messenger-platform.

As part of our setup we used the following backend services:<br />
Heroku - Free Dynos.<br />
ClearDB MySql - Ignite.<br />
SendGrid - Starter.<br />

Thus services are not essential, but are the easiest & fastest way to get started.

### License
This project have no license.

Everyone is invited to clone the project and do whatever they like with it, including but not limited to selling, rewriting, distributing, intergrating and so on.


### Contributors
Andrei Richkov - Project team leader, DevOps, programmer.<br />
Arik Lev Liber - Mentor, supplied the Facebook Messanger integration boilerplate code.<br />
Eran Shimony - Database Interactions, programmer.<br />
Shlomi Saad - Backend logic programmer.<br />
