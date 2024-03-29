<?php

use Symfony\Component\Yaml\Exception\ParseException;

/**
 *
 */
class CSSParser
{
    /**
     * @var
     */
    public $css;
    /**
     * @var
     */
    public $file;
    /**
     * @var
     */
    protected $raw_css;

    /**
     * @param $file
     * @return void
     */
    public function read_from_file($file)
    {
        if (!empty($file) && file_exists($file)) {
            $this->file = $file;
            $this->raw_css = file_get_contents($file);
            $this->do_operation();
        } else {
            throw new InvalidArgumentException("Exact and correct file path needed.");
        }
    }

    /**
     * @return void
     */
    private function do_operation()
    {
        preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $this->raw_css, $level1);
        unset($this->raw_css);
        if (count($level1) == 3) {
            $parent = count($level1[1]);
            $parent_value = count($level1[2]);
            if ($parent == $parent_value) {
                for ($i = 0; $i < $parent; $i++) {
                    //$this->css[trim($level1[1][$i])] = explode(";",trim($level1[2][$i]));
                    $level2 = explode(";", trim($level1[2][$i]));
                    foreach ($level2 as $l2) {
                        if (!empty($l2)) {
                            $level3 = explode(":", trim($l2));
                            $this->css[$this->clean($level1[1][$i])][$this->clean($level3[0])] = $this->clean($level3[1]);
                            unset($level3);
                        }
                    }
                    unset($level2, $l2);
                }
            } else {
                throw new ParseException("css is not parsable");
            }
            /*echo "<pre>";
            var_dump($level1);
            var_dump($this->css);*/
            unset($level1);
        } else {
            throw new ParseException("css is not parsable");
        }
    }

    /**
     * @param $value
     * @return string
     */
    private function clean($value)
    {
        return addslashes(trim($value));
    }

    /**
     * @param $str
     * @return void
     */
    public function read_from_string($str)
    {
        if (!empty($str)) {
            $this->raw_css = $str;
            $this->do_operation();
        } else {
            echo "String is empty.";
            exit(0);
        }
    }

    /**
     * @param $parent
     * @return array|mixed
     */
    public function find_parent($parent)
    {
        $parent = $this->clean($parent);
        if (isset($this->css[$parent])) {
            return $this->css[$parent];
        }

        return [];

    }

    /**
     * @param $property
     * @return array
     */
    public function find_parent_by_property($property)
    {
        $results = array();
        $property = $this->clean($property);
        foreach ($this->css as $key1 => $css) {
            foreach ($css as $key2 => $value2) {
                if ($key2 == $property) {
                    $results[][$key1] = $css;
                    break 1;
                }
            }
        }

        return $results;
    }

    /**
     * @param $pvalue
     * @return array
     */
    public function find_parent_by_value($pvalue)
    {
        $results = array();
        $pvalue = $this->clean($pvalue);
        foreach ($this->css as $key1 => $css) {
            foreach ($css as $key2 => $value2) {
                if ($value2 == $pvalue) {
                    $results[][$key1] = $css;
                    break 1;
                }
            }
        }

        return $results;
    }

    /**
     * @param $property
     * @param $value
     * @return array
     */
    public function find_property_value_pair($property, $value)
    {
        $results = array();
        $one = $this->clean($property);
        $two = $this->clean($value);
        foreach ($this->css as $key1 => $css) {
            foreach ($css as $key2 => $value2) {
                if ($key2 == $one && $value2 == $two) {
                    $results[][$key1] = $css;
                    break 1;
                }
            }
        }

        return $results;
    }

    /**
     * @param $parent
     * @param $value
     * @return true|void
     */
    public function add_parent($parent, $value = array())
    {
        if (!empty($parent)) {
            $parent = $this->clean($parent);
            if (isset($this->css[$parent]) == false) {
                if (is_array($value) == true) {
                    $this->css[$parent] = $value;

                    return true;
                } elseif (empty($value) == true) {
                    $this->css[$parent] = array();

                    return true;
                } else {
                    echo "2nd argument should be an array.";
                    exit(0);
                }
            } else {
                if (is_array($value) == true && !empty($value)) {
                    foreach ($value as $k => $v) {
                        $this->css[$parent][$k] = $v;

                        return true;
                    }
                } else {
                    echo "2nd argument should be an array.";
                    exit(0);
                }
            }
        } else {
            echo "Need parent tag name before performing any addition.";
            exit(0);
        }
    }

    /**
     * @param $current_name
     * @param $new_name
     * @return bool|void
     */
    public function rename_parent($current_name, $new_name)
    {
        $current_name = $this->clean($current_name);
        $new_name = $this->clean($new_name);
        if (!empty($current_name) && !empty($new_name) && ($current_name != $new_name)) {
            if (isset($this->css[$current_name]) == true) {
                $this->css[$new_name] = $this->css[$current_name];
                $this->remove_parent($current_name);

                return true;
            } else {
                return false;
            }
        } else {
            echo "Parent tag's current and new both name require.";
            exit(0);
        }
    }

    /**
     * @param $parent
     * @return bool
     */
    public function remove_parent($parent)
    {
        $parent = $this->clean($parent);
        if (isset($this->css[$parent]) == true) {
            unset($this->css[$parent]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $parent
     * @param $property
     * @param $value
     * @param $upsert
     * @return bool|void
     */
    public function add_property($parent, $property, $value, $upsert = false)
    {
        if (!empty($parent) && !empty($property) && !empty($value)) {
            $parent = $this->clean($parent);
            $property = $this->clean($property);
            $value = $this->clean($value);
            if (isset($this->css[$parent]) == true || (isset($this->css[$parent]) == false && $upsert == true)) {
                $this->css[$parent][$property] = $value;

                return true;
            }

            return false;
        } else {
            echo "Need all 3 value.";
            exit(0);
        }
    }

    /**
     * @param $parent
     * @param $property
     * @param $value
     * @return bool|void
     */
    public function update_property($parent, $property, $value)
    {
        if (!empty($parent) && !empty($property) && !empty($value)) {
            $parent = $this->clean($parent);
            $property = $this->clean($property);
            $value = $this->clean($value);
            if (isset($this->css[$parent]) == true) {
                $this->css[$parent][$property] = $value;

                return true;
            }

            return false;
        } else {
            echo "Need all 3 value.";
            exit(0);
        }
    }

    /**
     * @param $parent
     * @param $property
     * @return bool|void
     */
    public function remove_property($parent, $property)
    {
        if (!empty($parent) && !empty($property)) {
            $parent = $this->clean($parent);
            $property = $this->clean($property);
            if (isset($this->css[$parent]) == true) {
                unset($this->css[$parent][$property]);

                return true;
            }

            return false;
        } else {
            echo "Need all 2 value.";
            exit(0);
        }
    }

    /**
     * @return true|void
     */
    public function save()
    {
        if (isset($this->file) == true && !empty($file) && file_exists($file)) {
            $css = $this->export_css();
            $fh = fopen($this->file, "w") or die("Fail to open " . $file . " with write permission.");
            fwrite($fh, $css);
            fclose($fh);
            unset($css);

            return true;
        } else {
            echo "CSS file name with exact path is missing.";
            exit(0);
        }
    }

    /**
     * @return string
     */
    public function export_css()
    {
        $css = '';
        if (isset($this->css) && count($this->css) > 0) {
            foreach ($this->css as $level_1_key => $level_1_value) {
                $css .= stripslashes($level_1_key) . " {\n";
                foreach ($level_1_value as $level_2_key => $level_2_value) {
                    $css .= "\t" . stripslashes($level_2_key) . " : " . stripslashes($level_2_value) . ";\n";
                }
                $css .= "}\n";
            }
        }

        return $css;
    }

    /**
     *
     */
    public function __destruct()
    {
        unset($this->css, $this->raw_css, $this->file);
    }
}
