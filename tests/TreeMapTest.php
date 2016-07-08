<?php

namespace Drupal\Tests\Component\TypeGraph;

use Drupal\Component\TypeGraph\ComplexNode;
use Drupal\Component\TypeGraph\ListNode;
use Drupal\Component\TypeGraph\TreeMap;

/**
 * @coversDefaultClass \Drupal\Component\TypeGraph\TreeMap
 */
class TreeMapTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers ::fmap
   */
  public function testFmap() {
    $tree = new ComplexNode(1);
    $tree = $tree
      ->addNode('key1', 2)
      ->addNode('key2', 3)
      ->addNode('key3', new ListNode(4, NULL));

    $tree_map = new TreeMap(function ($i) {
      return $i + 1;
    });
    $result_tree = $tree_map->fmap($tree);

    $expected_tree = new ComplexNode(2);
    $expected_tree = $expected_tree
      ->addNode('key1', 3)
      ->addNode('key2', 4)
      ->addNode('key3', new ListNode(5, NULL));
    $this->assertEquals($expected_tree, $result_tree);
  }

}
