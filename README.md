
# Yourls Telegram Notifier [![Listed in Awesome YOURLS!](https://img.shields.io/badge/Awesome-YOURLS-C5A3BE)](https://github.com/YOURLS/awesome-yourls/)

<!-- Once you have committed code, get your plugin listed in Awesome YOURLS ! See https://github.com/YOURLS/awesome-yourls -->
This plugin allows you to to send a telegram message to one ore multiple Telegram accounts or channel with a bot you can create in the Telegram App whenever a new shortlink is created. 

Requires [YOURLS](https://yourls.org) `1.9.1` and above.

## Usage
| Admin Page :camera: | Example Telegram Notifications :camera:|
|--|--|
|![enter image description here](https://raw.githubusercontent.com/XLixl4snSU/universal-docs/main/yourls-telegram-notifier/desktop_screenshot.png)  | ![enter image description here](https://raw.githubusercontent.com/XLixl4snSU/universal-docs/main/yourls-telegram-notifier/mobile_screenshot.png)|

 

 - Get notified whenever a new link is added to your yourls database
 - Easy setup with the plugin configuration page
 - Custom notification messages with placeholders for the shortened URL, the keywoard and IP that submitted the request
 - Notify multiple users and/or channels at the same time (this should work without issues for up to 30 receivers). Just enter all IDs/channel names separated by comma.

## Installation

1. In `/user/plugins`, create a new folder named `telegram-notifier`.
2. Drop these files in that directory.
3. Go to the Plugins administration page (eg. `http://sho.rt/admin/plugins.php`) and activate the plugin.
4. Message `@botfather` on Telegram and create a new bot following the instructions. Insert the obtained bot token in plugin settings page.
5. Your bot can message to individual users and channels (if it has the rights). To send a notification to yourself, obtain your Telegram user ID by messaging `@myidbot` and paste it in the "Telegram User ID(s)" field. 

**IMPORTANT:** You need to message your bot first (message content does not matter) until it is able to send you messages. This is a security measure implemented by Telegram to prevent spam.

6. To send a message to a broadcast channel just use `@channel_name` (don't forget the "@") instead of a the numeric user ID.
7. Save settings and send a test message via the interface.
8. Have fun!

## License


This package is licensed under the [MIT License](LICENSE).
