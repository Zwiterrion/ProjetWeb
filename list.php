<?php


class Elem
{
   public $List;

   public $Prev = null;
   public $Elem = null;
   public $Next = null;

   
   public function __construct($l,$e)
   {
      $this->List = $l;
      $this->Elem = $e;
   }

   public function insertBefore($e)
   {
      $before = new Elem($this->List,$e);

      $before->Next = $this;
      $before->Prev = $this->Prev;
      
      if ($this->Prev == null)
	 $this->List->First = $before;
      else
	 $this->Prev->Next = $before;

      $this->Prev = $before;
      
      $this->List->Count++;
   }

   public function insertAfter($e)
   {
      $after = new Elem($this->List,$e);

      $after->Prev = $this;
      $after->Next = $this->Next;
      
      if ($this->Next == null)
	 $this->List->Last = $after;
      else
	 $this->Next->Prev = $after;

      $this->Next = $after;
      
      $this->List->Count++;
   }
   public function delete()
   {
      if ($this->Prev == null)
	 $this->List->First = $this->Next;
      else
	 $this->Prev->Next = $this->Next;

      if ($this->Next == null)
	 $this->List->Last = $this->Prev;
      else
	 $this->Next->Prev = $this->Prev;

      $this->List->Count--;
   }
}


class DoublyLinkedList implements Iterator, Countable
{
   public $First = null;
   public $Last  = null;
   public $Count = 0;
   
   public $Current = null;
   public $Index = -1;


   function push($e)
   {
      if ($this->Count == 0)
      {
	 /* init */
	 $this->First = new Elem($this,$e);
	 $this->Last = $this->First;
	 $this->Count = 1;
      }
      else
	 $this->Last->insertAfter($e);
   }
   
   function pop()
   {
      if ($this->Count > 0)
      {
	 $ret = $this->Last;
	 $this->Last->delete();
	 return $ret;
      }
      else
	 return false;
   }

   
   /* Countable */
   public function count()
   {
      return $this->Count;
   }


   /* Iterator */
   public function current()
   {
      return $this->Current;
   }

   public function key()
   {
      return $this->Index;
   }

   public function next()
   {
      $this->Current = $this->Current->Next;
      $this->Index++;
   }

   public function rewind()
   {
      $this->Current = $this->First;
      $this->Index = 0;
   }

   public function valid()
   {
      if ($this->Current == null or $this->Index < 0)
	 return false;
      else
	 return true;
   }
}



class KeyValue
{
   public $Key;
   public $Value;

   public function __construct($k,$v)
   {
      $this->Key   = $k;
      $this->Value = $v;
   }
}


class SortedList extends DoublyLinkedList
{
   public $Max = -1;

   public function addSorted($k, $v)
   {
      if ($this->count() == 0)
	 $this->push(new KeyValue($k, $v));
      else
      {
	 $item;
	 foreach($this as $item)
	 {
	    if ($item->Elem->Key < $k)
	       break;
	 }

	 $item->insertBefore(new KeyValue($k,$v));
	 if ($Max > 0 && $this->count() > $this->Max)
	    $this->pop();
      }
   }
}







/* Debug */
function listTest()
{
   $l = new SortedList();
   $l->push('a');
   $l->push('c');
   $l->push('d');

   $l->rewind();
   $l->next();
   $l->current()->insertBefore('b');

   echo "\n" . $l->count() . ': ';
   foreach($l as $e)
   {
      echo '['. $e->Elem .']';
   }
   echo "\n";
}
//listTest();
