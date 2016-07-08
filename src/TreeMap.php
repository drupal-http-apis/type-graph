<?php

namespace Drupal\Component\TypeGraph;

class TreeMap {

  protected $callable;

  /**
   * Creates a new TreeMap instance.
   *
   * @param callable $callable
   */
  public function __construct(callable $callable) {
    $this->callable = $callable;
  }

  public function fmap(Node $node) {

    if ($node instanceof ComplexNode) {
      $node = $node->setValue(call_user_func($this->callable, $node->getValue()));
      /** @var \Drupal\Component\TypeGraph\ComplexNode $node */
      foreach ($node->getNodes() as $key => $subnode) {
        $node = $node->addNode($key, $this->fmap($subnode));
      }
    }
    elseif ($node instanceof ListNode) {
      /** @var \Drupal\Component\TypeGraph\ListNode $node */
      $node = $node->setValue($node->getValue());
    }
    else {
      $node = $node->setValue(call_user_func($this->callable, $node->getValue()));
    }

    return $node;
  }

}
