<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Constants;

final class Http
{
    public const int HTTP = 80;
    public const int HTTPS = 443;

    public const string HEADER_HTTPS = 'HTTPS';
    public const string HEADER_PORT = 'SERVER_PORT';
    public const string HEADER_PROTO = 'HTTP_X_FORWARDED_PROTO';
    public const string HEADER_SSL = 'HTTP_X_FORWARDED_SSL';
    public const string HTTP_CF_CONNECTING_IP = 'HTTP_CF_CONNECTING_IP';
    public const string HTTP_CLIENT_IP = 'HTTP_CLIENT_IP';
    public const string HTTP_X_FORWARDED_FOR = 'HTTP_X_FORWARDED_FOR';
    public const string HTTP_X_REAL_IP = 'HTTP_X_REAL_IP';
    public const string REMOTE_ADDR = 'REMOTE_ADDR';

    public const string SCHEMA_HTTP = 'http://';
    public const string SCHEMA_HTTPS = 'https://';
}
