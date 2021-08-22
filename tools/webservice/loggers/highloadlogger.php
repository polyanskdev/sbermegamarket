<?

namespace Citfact\SiteCore\Tools\WebService\Loggers;

use Exception;
use Citfact\SiteCore\Entity\IntegrationRequest\IntegrationRequestRepository;

class HighloadLogger extends BaseLogger
{
    private IntegrationRequestRepository $entity;

    /**
     * HighloadLogger constructor.
     */
    public function __construct()
    {
        $this->entity = new IntegrationRequestRepository();
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function write(array $data): void
    {
        $res = $this->entity->add($data);
        if (!$res->isSuccess()) {
            throw new Exception(implode('; ', $res->getErrorMessages()));
        }
    }
}
