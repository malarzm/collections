# Collections

Various implementations of Doctrine's Collection interface allowing you to kickstart development of own ones. Each time
an interface or an abstract class requires you to implement `compare` method it needs a standard PHP comparison function
that returns an integer less than, equal to, or greater than zero if the first argument is considered to be respectively
less than, equal to, or greater than the second.

This library sports:

## SortedCollection

Collection that ensures it is always sorted, uses `uasort` by default however this can be changed via constructor
argument. Example usage:

```php
class SortedCollection extends Malarzm\Collections\SortedCollection
{
    public function compare($a, $b)
    {
        // ...
    }
}

$coll = new SortedIntCollection([], 'usort');
```

## ObjectSet

Collection that ensures it contains only one instance of a given object at a time thus providing very efficient
`contains` calls. Add/set calls are NOP in case of object being already in the collection.

It's ready to use right away.

## Set

More general version of `ObjectSet` that bases on custom comparison function instead of object hashes effectively
allowing you to store any kind of values in it. Add/set calls are NOP in case of value being already in the collection.

```php
class Set extends Malarzm\Collections\Set
{
    public function compare($a, $b)
    {
        // ...
    }
}
