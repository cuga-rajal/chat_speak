# chat_speak
Chatter v1.1 Notes
Cuga Rajal, March 7, 2022

"chatter.php" is a shell script that can be used to speak local chat of Firestorm,
using the built-in text-to-speech feature of macOS.

Get the latest version of the script from: https://github.com/cuga-rajal

How to set up:

1) In macOS 12 or later, go to System Preferences -> Accessibility -> Spoken Content

(In In macOS 10.12 to 10.15, go to System Preferences -> Accessibility -> Speech)
    
Click the System Voice drop-down menu and select Customize at the bottom of the
list. In the window that appears, select (if not already selected) all voices
for English (United States) including Siri voices. Also select the non-Siri
voices for all other English language variants. (Skip English - Novelty). Click
the "OK" button and wait for all voice downloads to complete.

Check the list of $voices in the chatter.php script and adjust as needed to match 
the enabled voices on your system.

2) The program requires PHP. On macOS 12 or later this must be installed with Homebrew.

	brew install php
	
Check that php is installed at /opt/homebrew/bin/php

3) In Firestorm, go to the Preferences window and select Privacy -> Logs & Transcripts

Check the checkbox "Save nearby chat transcript" 

4) Log in to Second Life or Opensim if you aren't already

5) Run the pre-compiled application provided or run the script in a terminal window.

To run the script in a terminal window:

Open a window for the Terminal program and type

    php [full path to chatter.php]

for example, if you place the script on your desktop, you could use:

    php ~/Desktop/chatter.php

You should begin to hear the computer speak each line of local chat from other avatars. 

The file "Chatter.app.zip" is an app wrapper for the program. It can be double-clicked to run.
It was created using Platypus, https://www.sveinbjorn.org/platypus

The script filters out some system messages. It only supports English at this time.

This is a work in progress. Please notify me of bugs or feature requests.

Thanks,

Cuga Rajal (Second Life and OSGrid)
cugarajal@gmail.com
