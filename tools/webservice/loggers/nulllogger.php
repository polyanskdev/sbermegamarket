<?

namespace Citfact\SiteCore\Tools\WebService\Loggers;

class NullLogger extends BaseLogger
{
    /**
     * @param array $data
     * @return void
     */
    public function write(array $data): void
    {
    }
}
