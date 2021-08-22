<?

namespace Citfact\SiteCore\Tools\WebService\Loggers;

abstract class BaseLogger
{
    /**
     * @param array $data
     * @return void
     */
    abstract public function write(array $data): void;
}
