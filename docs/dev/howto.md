How to
======

Update translation
-----------


* Exec this command:

      php bin/console translation:update --dump-messages --force --no-backup --output-format xlf en AppBundle
* Copy the difference in `src/AppBundle/Resources/translations/messages.en.xlf`

      <trans-unit id="a6c0a990c9b29e8bb8fbf3dff9d43fed" resname="load.explanation">
        <source>load.explanation</source>
        <target>en__load.explanation</target>
      </trans-unit>
* Paste it in `src/AppBundle/Resources/translations/messages.en.xlf`
* Translate the two files.
