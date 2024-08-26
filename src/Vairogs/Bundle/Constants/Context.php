<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Bundle\Constants;

enum Context: string
{
    case ALLOW_OPERATION = 'VAIROGS_MAPPER_ALLOW_OPERATION';
    case ALLOW_ROLE = 'VAIROGS_MAPPER_ALLOW_ROLE';
    case ALREADY_NORMALIZED = 'VAIROGS_MAPPER_ALREADY_NORMALIZED';
    case CALLER_CLASS = 'VAIROGS_MAPPER_CALL_CLASS';
    case CLASSES_WITH_ATTR = 'VAIROGS_MAPPER_CLASSES_WITH_ATTR';
    case ENTITY_NORMALIZER = 'VAIROGS_MAPPER_ENTITY_NORMALIZER';
    case FOUND_FILES = 'VAIROGS_MAPPER_FOUND_FILES';
    case GET_READ_PROP = 'VAIROGS_MAPPER_GET_READ_PROP';
    case IS_READ_PROP = 'VAIROGS_MAPPER_IS_READ_PROP';
    case MAP = 'VAIROGS_MAPPER_MAP';
    case MAPPER_LEVEL = 'VAIROGS_MAPPER_MAPPER_LEVEL';
    case MAPPER_PARENTS = 'VAIROGS_MAPPER_PARENTS';
    case READ_PROPERTY = 'VAIROGS_MAPPER_READ_PROPERTY';
    case REFLECTION = 'VAIROGS_MAPPER_REFLECTION';
    case RELATION_NAME = 'VAIROGS_MAPPER_RELATION_NAME';
    case RESOURCE_FILES = 'VAIROGS_MAPPER_RESOURCE_FILES';
    case RESOURCE_PROPERTIES = 'VAIROGS_MAPPER_RESOURCE_PROPERTIES';
    case SUPPORT_OPERATION = 'VAIROGS_MAPPER_SUPPORT_OPERATION';
    case SUPPORT_ROLE = 'VAIROGS_MAPPER_SUPPORT_ROLE';
}