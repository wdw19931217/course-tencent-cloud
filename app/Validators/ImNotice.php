<?php

namespace App\Validators;

use App\Exceptions\BadRequest as BadRequestException;
use App\Repos\ImNotice as ImNoticeRepo;

class ImNotice extends Validator
{

    public function checkNotice($id)
    {
        $repo = new ImNoticeRepo();

        $notice = $repo->findById($id);

        if (!$notice) {
            throw new BadRequestException('im_notice.not_found');
        }

        return $notice;
    }

    public function checkContent($content)
    {
        $value = $this->filter->sanitize($content, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length < 1) {
            throw new BadRequestException('im_notice.content_too_short');
        }

        if ($length > 1000) {
            throw new BadRequestException('im_notice.content_too_long');
        }

        return $value;
    }

}
