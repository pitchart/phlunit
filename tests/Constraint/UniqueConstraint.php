<?php


namespace Tests\Pitchart\Phlunit\Constraint;


trait UniqueConstraint
{
    public function test_is_a_unique_constraint()
    {
        $this->assertCount(1, $this->constraint);
    }
}