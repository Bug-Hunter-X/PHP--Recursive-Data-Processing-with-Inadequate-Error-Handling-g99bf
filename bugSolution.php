```php
function processData(array $data): array
{
  $result = [];
  foreach ($data as $item) {
    try {
      if (is_array($item)) {
        $result = array_merge($result, $this->processData($item));
      } else if (is_string($item) && strpos($item, '@') !== false) {
        $parts = explode('@', $item);
        if (count($parts) === 2) {
          list($key, $value) = $parts;
          $result[$key] = $value;
        } else {
          throw new InvalidArgumentException("Invalid data format: " . $item);
        }
      }
    } catch (InvalidArgumentException $e) {
      error_log("Error processing data: " . $e->getMessage());
      // Optionally:  Handle the error more robustly, e.g. skip the faulty item. 
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
    "email@john.doe@example.com" 
  ]
];

$processedData = processData($data);
print_r($processedData);
```