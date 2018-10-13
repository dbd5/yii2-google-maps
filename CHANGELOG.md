Yii2 google maps change log
==============================

- Bug: If map center is set as array, line 63 of mapinput.php throws up a bug for duplicated braces;
- Enh: added public parameter apiKeyParamsKey to Map.php and MapInput.php; 
       If google maps key is already in your project params array, simply add the params key to this variable.
- Enh: added public parameter mapLoaded to Map.php and MapInput.php; 
       If google maps is already initialized globally in your project, simply set this variable to true so maps is not loaded again.
- Enh: modified map.php and mapinput.php to test and run loadScript() based on the new parameters ; 
- Enh: modified init() functions in map.php and mapinput.php to set maps Api key from app params array if provided ; 
