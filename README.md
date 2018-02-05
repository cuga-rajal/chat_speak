# chat_speak
Chatter v1.0 Notes
Cuga Rajal, February 4, 2018

This is a shell script that can be used to speak local chat in Firestorm,
using the built-in text-to-speech feature of macOS.

Get the latest version of the script from: https://github.com/cuga-rajal

How to use:

1) In macOS 10.12 or later, go to
    System Preferences -> Accessibility -> Speech
    
Click the System Voice menu and select Customize at the bottom of the list.
In the window that appears, select (if not already selected) all voices
for English (United States) Male and Female, and all voices for 
English (Australia), English (India) and all other English variants.
Click the "OK" button and wait for all voice downloads to complete.

2) In Firestorm, go to the Preferences window and select
    Privacy -> Logs & Transcripts

Check the checkbox "Save nearby chat transcript" 

3) Log in to Second Life or Opensim if you aren't already

4) Open a window for the Terminal program and type

    php [full path to chatter.php]

for example, if you place the script on your desktop, you could use:

    php ~/Desktop/chatter.php

You should now hear the computer speak each line of local chat from other avatars. 

The script does filter out some system messages.

This is a work in progress. Please notify me of bugs or feature requests.

Thanks,

Cuga Rajal (Second Life and OSGrid)
cugarajal@gmail.com
