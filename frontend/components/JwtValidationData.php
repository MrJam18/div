<?php
namespace frontend\components;
use yii\base\Component;
use Lcobucci\JWT\ValidationData;

class JwtValidationData extends Component
{
    public ?int $currentTime = null;

    public int $leeway = 0;

    protected ValidationData $validationData;

    /**
     * ValidationData constructor.
     * @param ValidationData $validationData
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->validationData = new ValidationData($this->currentTime, $this->leeway);
        parent::__construct($config);
    }

    /**
     * @return ValidationData
     */
    public function getValidationData(): ValidationData
    {
        return $this->validationData;
    }

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->validationData->setIssuer('http://example.com');
        $this->validationData->setAudience('http://example.org');
        $this->validationData->setId('4f1g23a12aa');

        parent::init();
    }
}