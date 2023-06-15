<?php

namespace MediaConchBundle\Lib\Checks;

class Group
{
    public $abstract;
    
    public function __construct($abstract = null)
    {
        $this->abstract = $abstract;
    }
}

$GLOBALS['dbGroups'] =
[
    'Best_practice' => new Group(
        'Best practice in order to improve interoperability between implementations'
    ),
    'Crosscheck' => new Group(
        'Crosscheck between the value in the container (usually from readout of the content) and the actual value in the content'
    ),
    'General_compliance' => new Group(
        'Syntaxically correct but resulting bitstream is not coherent and may not be fit a specific constraint'
    ),
    'Update_needed' => new Group(
        'A reserved value is used, if the reserved value is expected it means that the checker is outdataed and needs an update'
    ),
];

class Groups
{
    public static function listGroups()
    {
        global $dbGroups;
        
        // List
        foreach (array_keys($dbGroups) as $groupId) {
            $list[] = '<a href="Groups/' . $groupId . '">' . str_replace('_', ' ', $groupId) . '</a>';
        }
        $data [] = [ 'List of groups with at least 1 check supported', [ [ null, $list ] ] ];
        
        return $data;
    }

    public static function listGroupInfo($groupId)
    {
        global $dbGroups;
        
        $group = $dbGroups[$groupId];
        if (!$group) {
            return null;
        }

        // Short name
        $data [] = [ 'Short name of this field', [ [ null, [ str_replace('_', ' ', $groupId) ] ] ] ] ;

        // Abstract
        if (isset($group->abstract)) {
            $data [] = [ 'Abstract', [ [ null, [ $group->abstract ] ] ] ] ;
        }

        // Checks
        $checks = (new Checks)->getGroupChecks($groupId);
        if (!empty($checks)) {
            $data [] = [ 'List of checks involving this group', [ [ null, $checks ] ] ] ;
        }
        
        return $data;
    }
}
