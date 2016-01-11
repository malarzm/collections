# Collections

Various implementations of Doctrine's Collection interface. This library sports:

## SortedCollection

Collection that ensures it is always sorted, uses `uasort` by default however this can be changed via constructor
argument. Example usage:

```php
class SortedIntCollection extends Malarzm\Collections\SortedCollection
{
    public function compare($a, $b)
    {
        if ($a > $b) {
            return 1;
        } elseif ($a === $b) {
            return 0;
        } else {
            return -1;
        }
    }
}

$coll = new SortedIntCollection([], 'usort');
```
