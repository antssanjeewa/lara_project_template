<?php

namespace App\Http\Traits;

trait RemarkCreator
{

  public function addRemark(){
    $this->remarks()->create([
      'body' => "Create New",
      'user_id' => auth()->user()->id
    ]);
  }

  public function deleteRemark(){
    $this->remarks()->create([
      'body' => "Deleted",
      'user_id' => auth()->user()->id
    ]);
  }

  public function updateRemark($old, $remark)
  {
    $text = $this->changeItems($old);

    $this->remarks()->create([
      'body' => $remark."-\n".$text,
      'user_id' => auth()->user()->id
    ]);
  }


  private function changeItems($old)
  {
    $change = array_keys($this->getChanges());
    $text = '';

    foreach ($change as $key) {
      if ($key != 'updated_at')
        $text .= $key . ' : ' . $old[$key] . ' => ' . $this[$key] . ',';
    }

    return $text;
  }
}
