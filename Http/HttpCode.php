<?php
/**
 * Project CoreSite.
 * @author: Dmitriy Shuba <sda@sda.in.ua>
 * @link: http://maxi-soft.net/ Maxi-Soft
 */

namespace CoreSite\CoreBundle\Http;


abstract class HttpCode
{
    const GET_FORBIDDEN_CODE           = 403;
    const GET_FORBIDDEN_MESSAGE        = 'Forbidden';

    const GET_NOT_FOUND_CODE           = 404;
    const GET_NOT_FOUND_MESSAGE        = 'Not found';

    const POST_SUCCESS_CODE            = 201;
    const POST_SUCCESS_MESSAGE         = 'Created';

    const POST_CREATED_CODE            = 201;
    const POST_CREATED_MESSAGE         = 'Created';

    const PUT_SUCCESS_CODE             = 202;
    const PUT_SUCCESS_MESSAGE          = 'Updated';

    const POST_FAIL_CODE               = 400;
    const POST_FAIL_MESSAGE            = 'Bad Request';

    const PUT_FAIL_CODE                = 400;
    const PUT_FAIL_MESSAGE             = 'Bad Request';

    const DELETE_SUCCESS_CODE          = 201;
    const DELETE_SUCCESS_MESSAGE       = 'Deleted';

    const DELETE_FAIL_CODE             = 400;
    const DELETE_FAIL_MESSAGE          = 'Not deleted';
}
