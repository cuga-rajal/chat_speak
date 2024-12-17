# chat_speak
Chatter v.1.7 - Dec 17, 2024
by Cuga Rajal

This script will speak the local chat in macOS Firestorm, using macOS built-in text-to-speech.

More information at https://github.com/cuga-rajal/chat_speak

*General requirements*

Before you run the script you will need to check your system for installed voices and install
additional ones if necessary. 

	System Settings -> Accessibility -> Spoken Content -> System Voice -> Manage Voices (or "?" circle)

If necessary, edit the $voices section in the script to match the list of voices installed on your system.
The $voices list is a mix of English-speaking voices available on Monterey (13.x) and later systems.

You will also need to configure your macOS Firestorm viewer to "Save nearby chat transcript" in:

	Preferences -> Privacy -> Log & Transcripts

Lastly, your system must have PHP installed. On macOS 12 or later this can be installed with Homebrew.

	brew install php

*How to start*

Once configured, you will need to log into a virtual world before running the script.

You can run the script either from a terminal or by opening the wrapper application provided
in this repository.

To run the script in a terminal window:

Open a window for the Terminal program and type

	php [full path to chatter.php]

for example, if you place the script on your desktop, you could use:

    php ~/Desktop/chatter.php

You should begin to hear the computer speak each line of local chat from other avatars. 

The file "Chatter.app.zip" in the repository is a ZIP archive of an app wrapper for the program.
Just unzip it and double-click to start. 

It was created using Platypus, https://www.sveinbjorn.org/platypus

The app expects php to be located in
/opt/homebrew/bin/php which is standard for Apple Silicon systems. For Intel macOS systems
you may need to rebuild this app with Platypus using a modified path for php, typically
/usr/local/bin/php.

Version 1.7 includes some code cleanup and better filtering of long technical phrases such as URLs and
vectors.


This is a work in progress. Please notify me of bugs or feature requests.

Thanks,

Cuga Rajal (Second Life and OSGrid)
cuga@rajal.org

