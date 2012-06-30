<?php
/*

	== PHP FILE TREE ==

		Let's call it...oh, say...version 1?

	== AUTHOR ==

		Cory S.N. LaViska
		http://abeautifulsite.net/

	== DOCUMENTATION ==

		For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21

*/

class MgwFileTree
{

    private static $baseDir = '';

    public static function drawTree($directory, $return_link, $extensions = array())
    {
        // Generates a valid XHTML list of all directories, sub-directories, and files in $directory
        // Remove trailing slash

        $code = '';

        self::$baseDir = $directory;

        if(substr($directory, - 1) == "/") $directory = substr($directory, 0, strlen($directory) - 1);

        $code .= self::scanDir($directory, $return_link, $extensions);

        return $code;
    }

    private static function scanDir($directory, $return_link, $extensions = array(), $first_call = true)
    {
        $php_file_tree = '';
        // Recursive function called by php_file_tree() to list directories/files

        // Get and sort directories/files
        $file = scandir($directory);

        natcasesort($file);

        // Make directories first
        $files = $dirs = array();

        foreach($file as $this_file)
        {
            if(is_dir("$directory/$this_file")) $dirs[] = $this_file;
            else $files[] = $this_file;
        }

        $file = array_merge($dirs, $files);

        // Filter unwanted extensions
        if(! empty($extensions))
        {
            foreach(array_keys($file) as $key)
            {
                if(! is_dir("$directory/$file[$key]"))
                {
                    $ext = substr($file[$key], strrpos($file[$key], ".") + 1);
                    if(! in_array($ext, $extensions)) unset($file[$key]);
                }
            }
        }

        if(count($file) > 2)
        { // Use 2 instead of 0 to account for . and .. "directories"
            $php_file_tree = "<ul";
            if($first_call)
            {
                $php_file_tree .= " class=\"php-file-tree\"";
                $first_call = false;
            }
            $php_file_tree .= ">";
            foreach($file as $this_file)
            {
                if(false !== strpos($this_file, '___'))
                    continue;

                if($this_file != "." && $this_file != "..")
                {
                    if(is_dir("$directory/$this_file"))
                    {
                        // Directory
                        $php_file_tree .= "<li class=\"pft-directory\"><a href=\"#\">".htmlspecialchars($this_file)."</a>";
                        $php_file_tree .= self::scanDir("$directory/$this_file", $return_link, $extensions, false);
                        $php_file_tree .= "</li>";
                    }
                    else
                    {
                        // File
                        // Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
                        $ext = "ext-".substr($this_file, strrpos($this_file, ".") + 1);

                        $d = trim(str_replace(self::$baseDir, '', $directory), '/');
                        if($d) $d = $d.'/';

                        $f = JFile::stripExt($this_file);

                        $link = str_replace('[link]', $d.urlencode($f), $return_link);
                        $php_file_tree .= '<li class="pft-file '.strtolower($ext).'">'
                            .'<a href="'.$link.'">'.htmlspecialchars($f).'</a>'
                            .'</li>';
                    }
                }
            }

            $php_file_tree .= "</ul>";
        }

        return $php_file_tree;
    }
}
