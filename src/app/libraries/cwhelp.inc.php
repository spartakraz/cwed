<?php

$CW_helpStr = <<<EOSTR

1. Main Menu Items
==================

FILE->NEW           Creates a new file and loads it in a new buffer. You will be prompted to specify basename of the file,
                    e.g. myfile.cpp. If the file belongs to a project, specify the project's name too, e.g.
                    myproject/myfile.cpp.
FILE->OPEN          Opens an existing file in a new buffer. You will be prompted to specify basename of the file,
                    e.g. myfile.cpp. If the file belongs to a project, specify the project's name too, e.g.
                    myproject/myfile.cpp.
FILE->SAVE          Saves current file.
FILE->DELETE        Deletes an existing file. The file must not be loaded in one of the open buffers. You will be prompted to
                    specify basename of the file, e.g. myfile.cpp. If the file belongs to a project, specify the project's
                    name too, e.g. myproject/myfile.cpp.
FILE->LIST          Updates the contents of the LoginDir tab, which displays the contents of the login directory.
FILE->TAR           Adds files to a TAR archive named cwed.tar. You will be prompted to specify base file names
                    separated by space, e.g. file.cpp<space>file2.cpp<space>file3.cpp. If the files belong to
                    a project you have to specify the project's name too, e.g., myproject/file1.cpp<space>myproject/file2.cpp.
FILE->MAIL          Sends a file as an attachment to an email account. You will be prompted to specify name of the file
                    and the email account separated by comma, e.g "myfile.cpp, mymail@myserver.net". If the file belongs
                    to a project you have to specify the project's name too, "myproject/myfile.cpp, mymail@myserver.net".
FILE->DOWNLOAD      Downloads a file. You will be prompted to specify basename of the file, eg myfile.cpp. If the file
                    belongs to a project, specify the project's name too, e.g. myproject/myfile.cpp
FILE->LOGOUT        Logs out from the current session and redirects to the login form.

BUFFER->SWITCH      Switches to a buffer by its number. You will be prompted to specify the number which can be looked up
                    in the Buffers tab. The operation fails if there are less than 2 buffers currently opened.
BUFFER->NEXT        Switches to the next buffer. The operation fails if there are less than 2 buffer2 currently opened.

EDIT->GOTO          Invokes standard Go To Line dialog.
EDIT->SEARCH        Invokes standard Search dialog.
EDIT->REPLACE       Invokes standard Replace dialog.
EDIT->FORMAT        Code autoformatting
EDIT->FUNCTIONS     Updates the contents of the Functions tab. The tab contains the list of all function declarations and
                    calls found in the editor. Just select a declaration or a call and the editor's cursor will
                    be automatically set to the line with this declaration/call.

SESSION->SET MAKE   Sets the current makefile. The current makefile is the one executed by the TEST->MAKE menu item.
                    You will be prompted to specify the basename of the makefile. The makefile must have .mkf extension.
SESSION->READ MAKE  Displays in the OUTPUT tab the current makefile set by the TEST->SET MAKE menu item.
SESSION->SET EXEC   Sets the current executable file. You will be prompted to specify basename of the file, eg
                    myexec.out. If the file belongs to a project, specify the project's name too, eg myproject/myexec.out
                    The current executable is the one to be tested by the TEST->RUN, TEST->TERMINAL and
                    DEBUG->BACKTRACE menu items.
SESSION->READ EXEC  Displays in the OUTPUT tab the current executable file set by TEST->SET EXEC menu item.

TEST->LINT          Checks the syntax of the current source file and outputs the results to the OUTPUT tab.
TEST->COMPILE       Compiles the current source file to machine code. The generated executable is named XXX.out
                    where XXX is the name of the current source file. The compilation results are displayed in the
                    Output tab.
TEST->ASM           Compiles the current source file to assembly. The generated assembly file is named XXX.s
                    where XXX is the name of the current source file. The generated assembly is then displayed in the ASM tab.
TEST->MAKE          Executes the current makefile. The makefile must be set in advance by SESSION->SET MAKE.
TEST->RUN           Runs the current executable file in a non-interactive mode. The program reads its input data from the
                    INPUT tab and writes its results to the OUTPUT tab. The current executable file must specified in advance
                    by SESSION->SET EXEC.
TEST->TERMINAL      Runs the current executable file in an interactive mode in the built-in terminal emulator. The current
                    executable file must be specified in advance by SESSION->SET EXEC.

DEBUG->BACKTRACE    Debugs the current executable file with the Backtrace command and writes the output to the OUTPUT tab.
                    The executable file must be specified in advance by SESSION->SET EXEC.

PROJECT->NEW        Creates a new project. You will be prompted to specify name of the project. A project is represented by a
                    dedicated directory and its makefile with the .mkf extension For example, if name of the project
                    is MYPROJECT then it is located in the directory named MYPROJECT and have a makefile named MYPROJECT.mkf.
PROJECT->DELETE     Drops an existing project. You will be prompted to specify name of the project.


2. Bottom Panels (Tabs)
=======================

OUTPUT              Displays messages from the IDE itself and the programs tested within in.
INPUT               Input data for the programs being tested by TEST->RUN, TEST->TERMINAL and DEBUG->BACKTRACE.
ASM                 Assembly generated by the TEST->ASM menu item.
FUNCTIONS           Displays the list of all function declarations, definitons and calls found in the current file.
                    On selecting an item from the list the editor's cursor is automatically located in the place
                    with the selected item. This panel is updated by EDIT->FUNCTIONS.
LOGIN_DIR           Displays contents of the login directory. Must be updated by FILE->LIST.
BUFFERS             Displays the list of currently opened buffers with their ordinal numbers.
SCRIBBLE            Used to keep miscellaneous notes and scratches.
ABOUT               Information about the application
HELP                User's manual

EOSTR;
?>
