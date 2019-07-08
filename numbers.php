<?php

/**
 * 1. UI shows up by method showNumbers()
 * 2. github repository: https://github.com/gymadarasz/numbers-test.git
 * 3. Sorry, I don't have a free AWS account at the moment but you can easyli can run by command: `php numbers.php`
 * 4. Plan: yas going trough numbers in an interval and generating the output
 * 5. Future plan: more separated code by following design patters, depending on feature taskes
 */
class NumberGenerator {

    /**
     * @var string - column template
     */
    protected $col = "<td>%s<td>";
    
    /**
     * @var string - row template
     */
    protected $row = "<tr>%s<tr>";
    
    /**
     * @var string - table template
     */
    protected $tbl = "<table>%s</table>";
    
    /**
     * generate output by a given interval and outputs
     * 
     * @param int $from - interval begin
     * @param int $to - interval end
     * @param int[] $nums - dividers
     * @param string[] $needs - search and replacements as a key -> value array
     * @param bool $shows - optional - shows output if TRUE (default is false)
     * @return string[] - results as array as strings
     * @throws Exception - Unexpected result, typically if no replacement for founds
     */
    public function getNumbers($from, $to, $nums, $needs, $shows = false) {
        for ($i=$from; $i<=$to; $i++) {
            $res = ''; 
            foreach ($nums as $num) {
                if ($i % $num == 0) {
                    $res .= "$num,";
                }
            }
            if (isset($needs[$res])) {
                $output = sprintf($needs[$res], $i);
                if ($shows) {
                    echo "$output\n";
                }
                $results[] = $output;
            }
            else {
                throw new Exception('hoops, no needs');
            }
        }
        return $results;
    }
    
    /**
     * generate/shows given results in a nice HTML table
     * 
     * @param string[] $numbers - data to show
     * @param int $width - optional - table size (default is 10)
     * @param int $height - optional - table size (default is 10)
     * @param bool $shows - optional - shows output is TRUE (default is true)
     * @return string - returns a formatted HTML output
     */
    public function showNumbers($numbers, $width = 10, $height = 10, $shows = true) {
        $i=0;
        $j=0;
        $col = '';
        $row = '';
        $tbl = '';
        foreach ($numbers as $number) {
            $i++;
            $col .= sprintf($this->col, $number);
            if ($i % $width == 0) {
                $j++;
                $row .= sprintf($this->row, $col);
                $col = '';
                if ($j % $height == 0) {
                    $tbl .= sprintf($this->row, $row);
                    $row = '';
                }
            }
        }
        $output = sprintf($this->tbl, $tbl);
        if ($shows) {
            echo $output;
        }
        return $output;
    }
}

/**
 * Test output
 */
$generator = new NumberGenerator();
$results = $generator->getNumbers(1, 100, [1, 3, 5], [
    '1,' => "%d",
    '1,3,' => "Coating damage",
    '1,5,' => "Lighting strike",
    '1,3,5,' => "Coating damage and Lighting strike",
]);
$generator->showNumbers($results);
