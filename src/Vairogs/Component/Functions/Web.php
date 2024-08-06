<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

final class Web
{
    use Web\_ArrayFromQueryString;
    use Web\_BuildArrayFromObject;
    use Web\_BuildHttpQueryArray;
    use Web\_BuildHttpQueryString;
    use Web\_CheckHttps;
    use Web\_CheckHttpXForwardedProto;
    use Web\_CheckHttpXForwardedSsl;
    use Web\_CheckServerPort;
    use Web\_CIDRRange;
    use Web\_IsAbsolute;
    use Web\_IsCIDR;
    use Web\_IsHttps;
    use Web\_IsIE;
    use Web\_IsUrl;
    use Web\_ParseHeaders;
    use Web\_RawHeaders;
    use Web\_RemoteIp;
    use Web\_RemoteIpCF;
    use Web\_RequestIdentity;
    use Web\_RequestMethods;
    use Web\_Result;
    use Web\_RouteExists;
    use Web\_Schema;
    use Web\_UrlEncode;
    use Web\_ValidateCIDR;
    use Web\_ValidateEmail;
    use Web\_ValidateIPAddress;

    public const string HTML = 'text/html';
    public const string JSON = 'application/json';
    public const string JSONLD = 'application/ld+json';
    public const string JSON_PATCH = 'application/merge-patch+json';
    public const string XLSX = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    public const string XML = 'application/xml';
    public const string X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

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

    public const int HTTP_BANDWIDTH_LIMIT_EXCEEDED = 509;
    public const int HTTP_BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;
    public const int HTTP_CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;
    public const int HTTP_DISCONNECTED_OPERATION = 112;
    public const int HTTP_ENHANCE_YOUR_CALM = 420;
    public const int HTTP_HEURISTIC_EXPIRATION = 113;
    public const int HTTP_INVALID_TOKEN = 498;
    public const int HTTP_MISCELLANEOUS_PERSISTENT_WARNING = 299;
    public const int HTTP_MISCELLANEOUS_WARNING = 199;
    public const int HTTP_NETWORK_CONNECT_TIMEOUT_ERROR = 599;
    public const int HTTP_NETWORK_READ_TIMEOUT_ERROR = 598;
    public const int HTTP_RESPONSE_IS_STALE = 110;
    public const int HTTP_RETRY_WITH = 449;
    public const int HTTP_REVALIDATION_FAILED = 111;
    public const int HTTP_SITE_IS_FROZEN = 530;
    public const int HTTP_SITE_IS_OVERLOADED = 529;
    public const int HTTP_THIS_IS_FINE = 218;
    public const int HTTP_TOKEN_REQUIRED = 499;
    public const int HTTP_TRANSFORMATION_APPLIED = 214;
}
