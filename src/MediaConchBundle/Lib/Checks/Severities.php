<?php

namespace MediaConchBundle\Lib\Checks;

class Severity
{
    public $abstract;
    
    public function __construct($abstract = null)
    {
        $this->abstract = $abstract;
    }
}

$GLOBALS['dbSeverities'] =
[
    'Error' => new Severity(
        'Incompatibile with specifications and leading for sure to playback issues, for example:<br>- conflict in specification with a sentence containing "must"<br>- some parts of the specification imply constraints on specific fields<br>- obviously problematic values leading to playback issue on allmost all or all players'
    ),
    'Warning' => new Severity(
        'Compatible with specifications but potentially leading to playback issues, for example:<br>- not precise in the specification but obviously problematic<br>- not recommended as a best practice, which may lead to interoperability issues with some players'
    ),
    'Info' => new Severity(
        'Relevant information interesting for the operator, for example:<br>- a value is marked as reserved in the known specification, so the conformance checker is not up to date<br>- a part of the specification is not implemented in the conformance checker'
    ),
];

class Severities
{
    public function listSeverities()
    {
        global $dbSeverities;
        
        // List
        $list = [];
        foreach (array_keys($dbSeverities) as $severityId) {
            $list[] = '<a href="Severities/' . $severityId . '">' . str_replace('_', ' ', $severityId) . '</a>';
        }
        $data = [];
        $data [] = [ 'List of severities with at least 1 test supported', [ [ null, $list ] ] ];
        
        return $data;
    }

    public function listSeverityInfo($severityId)
    {
        global $dbSeverities;
        
        $severity = $dbSeverities[$severityId];
        if (!$severity) {
            return null;
        }

        // Short name
        $data [] = [ 'Short name of this field', [ [ null, [ str_replace('_', ' ', $severityId) ] ] ] ] ;

        // Abstract
        if (isset($severity->abstract)) {
            $data [] = [ 'Abstract', [ [ null, [ $severity->abstract ] ] ] ] ;
        }

        // Checks
        $checks = (new Checks)->getSeverityChecks($severityId);
        if (!empty($checks)) {
            $data [] = [ 'List of checks involving this severity', [ [ null, $checks ] ] ] ;
        }
        
        return $data;
    }
}
