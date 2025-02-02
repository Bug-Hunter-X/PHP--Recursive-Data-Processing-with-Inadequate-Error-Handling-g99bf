```php
function processData(array $data): array
{
  $result = [];
  foreach ($data as $item) {
    if (is_array($item)) {
      $result = array_merge($result, $this->processData($item)); // Recursive call
    } else if (is_string($item) && strpos($item, '@') !== false) {
      // Process only strings containing '@'
      $parts = explode('@', $item);
      if (count($parts) === 2) {
        list($key, $value) = $parts;
        $result[$key] = $value;
      } else {
        //Handle cases with more than one '@' or other unexpected formats.
          //Here's where the error occurs. We need better error handling. 
        trigger_error("Invalid data format: " . $item, E_USER_WARNING);
      }
    }
  }
  return $result;
}

$data = [
  "name@John",
  "age@30",
  [
    "city@New York",
    "country@USA",
    "email@john.doe@example.com" //This will cause an issue
  ]
];

$processedData = processData($data);
print_r($processedData); 
```