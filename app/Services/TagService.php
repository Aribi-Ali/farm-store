<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagService
{
  const DEFAULT_PER_PAGE = 15;
  public function getPaginated(array $filters, int|null $perPage = self::DEFAULT_PER_PAGE)
  {


    // throw new CustomException("ya 3abita!", 404s);
    $tag = Tag::query();
    if (!empty($filters["search"])) {
      $tag->where("name", "like", "%" . $filters["search"] . "%")
        ->orWhere("name", "like", "%" . $filters["search"] . "%");
    }
    return $tag->paginate($perPage);
  }
  public function create(array $data)
  {

    DB::transaction(function () use ($data) {

      if (empty($data["isActive"])) {
        $data["isActive"] = false;
      }
      return  Tag::create($data);
    });
  }
  public function show($tagId)
  {
    $tag = Tag::findOr($tagId, function () use ($tagId) {
      throw new CustomNotFoundException("Tag with ID {$tagId} was not found.", 404);
    });
    return $tag;
  }
  public function update(array $data, $tagId)
  {
    $tag = Tag::findOr($tagId, function () use ($tagId) {
      throw new CustomNotFoundException("Tag with ID {$tagId} was not found.", 404);
    });
    $tag->update($data);
  }
  public function delete($tagId)
  {
    $tag = Tag::findOr($tagId, function () use ($tagId) {
      throw new CustomNotFoundException("Tag with ID {$tagId} was not found.", 404);
    });
    return  $tag->delete();
  }
}
