<?php
namespace PHPFuzzy;
/**
 *  Поиск полным перебором
 */
class ExhaustiveSearcher extends Searcher
{
    public function __construct($searchQuery, $maxDistance = MAX_DISTANCE)
    {
        parent::__construct($searchQuery, $maxDistance);        
        $this->measurements['search']   = [microtime(true)];
        $results                        = $this->search($searchQuery);
        $this->measurements['search'][] = microtime(true);
        foreach ($results as $result) {
            $this->results[] = $result;
        }
    }
    
    private function search($searchQuery)
    {
        $results = [];
        $dictionary = $this->dictionary->getDictionary();
        $count = count($dictionary);
        foreach ($dictionary as $index => $entry)
        {            
            if (levenshtein($searchQuery, $entry) <= $this->maxDistance)
            {
                $results[] = $entry;
            }
            Utils::progressBar($index, $count);
        }
        return $results;
    }        
}