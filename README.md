#SIATMA Bot

##About SIATMA Bot

SIATMA Bot is a web application for Universitas Atma Jaya Yogyakarta's students classes reminder that integrated with <a href="https://core.telegram.org/bots">Telegram Bot API</a>, <a href="https://developers.line.me/messaging-api/overview">LINE Messaging API</a>, and <a href="https://developers.facebook.com/products/messenger/">Facebook Messenger API</a> make with <a href="https://laravel.com">Laravel 5.4</a>. SIATMA Bot attempts to take the complicacy for students to checking their college routine with the help chatbot that using 3 major instant messenger usually used by students.

##Sample web

Please take a look in <a ="http://ditoraharjo.co/siatmabot/register">this</a> website and register to test the extent of the project functionality.

##Installation

Download all the component required using composer:

```shell
composer install
```

Open your database then import siatma_bot.sql, that will be automatically make the database("siatma_bot") for the project. Be noticed that all of my tables name is in Bahasa and acronym with my own taste of naming, so here are the list to translate it to become more understandable :

- chat_log -> will be filled with the list of all user that have been chat your bot in Telegram, but every user will be checked so there will be no duplicated user in there.
- chat_log_fb -> the same as chat_log, but this is for your Facebook bot.
- chat_log_line -> the same as chat_log, but this is for your LINE bot.
- fakultas -> that is to say Faculty in Bahasa, so this will be filled with list of Faculty in your university
- jadwal -> that is to say Schedule in Bahasa, so this will be filled with list of schedule input by user
- prodi -> when translated to English will be something like "Concentrations" or "Programs" of the faculty. This table will be filled with list of that "Programs".
- sesi -> that is to say Session in Bahasa, the college class time taken. To give you a simple example : my class started at 07.00 - 09.45 and my university standard called it First Session, then 10.00 - 12.30 is the Second Session. So this will be filled with list of session and the day of that session.
- sesi-prodi -> this is to relate between table "prodi" with table "sesi", because the relationship is N-N. I'm doing this because in my university the session's time is sometimes different for other "prodi". So this will be filled with list of "prodi" + "sesi" + the time of that session for the "prodi".
- users -> you know what this is.

And the last thing, you need to change the .env.example file to .env file and fill it with your configuration. How to get the Telegram, Facebook, and LINE API key? take a look at some tutorial in Youtube.

##Having a problem to understand the project?

please feel free to make an issue if you can't understand how to run this project or can't understand some code in the project, I'll try my best to reply it ASAP.

##N.B.

- Laravel I used for creating this project is Laravel 5.4
- This web application is made for my college project and I lived in Indonesia, so please understand some of the codes will be in Bahasa, but I will try to keep it minimize. By the way, sorry for my English.
