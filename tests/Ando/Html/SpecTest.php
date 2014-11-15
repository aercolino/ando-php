<?php
/**
 * Created by Andrea Ercolino.
 * IDE: PhpStorm
 * Date: 14/11/14
 * Time: 18:36
 */

class Ando_Html_SpecTest extends PHPUnit_Framework_TestCase
{
    public function test_info_non_existent_is_empty()
    {
        $this->assertEquals(array(), Ando_Html_Spec::info('xxx'));
    }

    /**
     * @covers Ando_Html_Spec::category_set
     */
    public function test_categories_created_as_expected()
    {
        $button = Ando_Html_Spec::info('button');
        $this->assertEquals(9, count($button['categories']));
        $this->assertContains('flow', $button['categories']);
        $this->assertContains('phrasing', $button['categories']);
        $this->assertContains('interactive', $button['categories']);
        $this->assertContains('form-associated', $button['categories']);
        $this->assertContains('listed', $button['categories']);
        $this->assertContains('submittable', $button['categories']);
        $this->assertContains('reassociateable', $button['categories']);
        $this->assertContains('labelable', $button['categories']);
        $this->assertContains('palpable', $button['categories']);

        $input = Ando_Html_Spec::info('input');
        $this->assertEquals(10, count($input['categories']));
        $this->assertContains('flow', $input['categories']);
        $this->assertContains('phrasing', $input['categories']);
        $this->assertContains('form-associated', $input['categories']);
        $this->assertContains('listed', $input['categories']);
        $this->assertContains('submittable', $input['categories']);
        $this->assertContains('resettable', $input['categories']);
        $this->assertContains('reassociateable', $input['categories']);
        $this->assertContains('interactive-if type attribute not hidden', $input['categories']);
        $this->assertContains('labelable-if type attribute not hidden', $input['categories']);
        $this->assertContains('palpable-if type attribute not hidden', $input['categories']);
    }

    public function test_input_has_category_interactive_iif_hidden()
    {
        $input_text = array('name' => 'input', 'attributes' => array());
        $visible_input = $this->getMock('Ando_Html_Node', array(), array($input_text));
        $visible_input->expects($this->once())
            ->method('name')
            ->willReturn($input_text['name']);
        $visible_input->expects($this->once())
            ->method('attributes')
            ->willReturn($input_text['attributes']);
        $this->assertTrue(Ando_Html_Spec::has_category($visible_input, 'interactive'));

        $input_text = array('name' => 'input', 'attributes' => array('type' => null));
        $visible_input = $this->getMock('Ando_Html_Node', array(), array($input_text));
        $visible_input->expects($this->once())
            ->method('name')
            ->willReturn($input_text['name']);
        $visible_input->expects($this->once())
            ->method('attributes')
            ->willReturn($input_text['attributes']);
        $this->assertTrue(Ando_Html_Spec::has_category($visible_input, 'interactive'));

        $input_text = array('name' => 'input', 'attributes' => array('type' => 'text'));
        $visible_input = $this->getMock('Ando_Html_Node', array(), array($input_text));
        $visible_input->expects($this->once())
            ->method('name')
            ->willReturn($input_text['name']);
        $visible_input->expects($this->once())
            ->method('attributes')
            ->willReturn($input_text['attributes']);
        $this->assertTrue(Ando_Html_Spec::has_category($visible_input, 'interactive'));

        $input_hidden = array('name' => 'input', 'attributes' => array('type' => 'hidden'));
        $hidden_input = $this->getMock('Ando_Html_Node', array(), array($input_hidden));
        $hidden_input->expects($this->once())
            ->method('name')
            ->willReturn($input_hidden['name']);
        $hidden_input->expects($this->once())
            ->method('attributes')
            ->willReturn($input_hidden['attributes']);
        $this->assertFalse(Ando_Html_Spec::has_category($hidden_input, 'interactive'));
    }
}
