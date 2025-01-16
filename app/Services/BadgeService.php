<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class BadgeService
{

  const DEFAULT_PER_PAGE = 15;
  public function __construct(public StorageService $storageService) {}


  public function getPaginated(array $filters = [], int|null $perPage = self::DEFAULT_PER_PAGE)
  {

    $query = Badge::query();

    // Apply filters
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }


    return $query->paginate($perPage);
  }

  public function create(array $data, ?UploadedFile $badgeFile = null)
  {

    return DB::transaction(function () use ($data, $badgeFile) {
      if ($badgeFile) {

        $data["path"] = $this->storageService->storeSingleImage("local_image_driver", null, "badges", $badgeFile);
      }
      return Badge::create($data);
    });
  }
  public function show($badgeId)
  {

    $badge = Badge::findOr($badgeId, function () use ($badgeId) {

      throw new CustomNotFoundException("Badge with ID {$badgeId} was not found.", 404);
    });


    return $badge;
  }
  public function update($badgeId, array $data, ?UploadedFile $badgeFile = null)
  {

    $badge = Badge::findOr($badgeId, function () use ($badgeId) {

      throw new CustomNotFoundException("Badge with ID {$badgeId} was not found.", 404);
    });

    return DB::transaction(function () use ($data, $badgeFile, $badge) {
      if ($badgeFile) {
        $this->storageService->deleteSingleImage("local_image_driver", null, "badges", $badge->path);
        $data["path"] = $this->storageService->storeSingleImage("local_image_driver", null, "badges", $badgeFile);
      }
      return $badge->update($data);
    });

    // delete and save  the badge image
  }
  public function delete($badgeId)
  {


    $badge = Badge::findOr($badgeId, function () use ($badgeId) {

      throw new CustomNotFoundException("Badge with ID {$badgeId} was not found.", 404);
    });
    if ($badge->path) {
      $this->storageService->deleteSingleImage("local_image_driver", null, "badges", $badge->path);
    }

    // add delete image later
    return $badge->delete();
  }
}
