<?php declare(strict_types=1);

namespace Shopware\Api\Payment\Definition;

use Shopware\Api\Entity\EntityDefinition;
use Shopware\Api\Entity\EntityExtensionInterface;
use Shopware\Api\Entity\Field\FkField;
use Shopware\Api\Entity\Field\LongTextField;
use Shopware\Api\Entity\Field\ManyToOneAssociationField;
use Shopware\Api\Entity\Field\StringField;
use Shopware\Api\Entity\FieldCollection;
use Shopware\Api\Entity\Write\Flag\PrimaryKey;
use Shopware\Api\Entity\Write\Flag\Required;
use Shopware\Api\Payment\Collection\PaymentMethodTranslationBasicCollection;
use Shopware\Api\Payment\Collection\PaymentMethodTranslationDetailCollection;
use Shopware\Api\Payment\Event\PaymentMethodTranslation\PaymentMethodTranslationDeletedEvent;
use Shopware\Api\Payment\Event\PaymentMethodTranslation\PaymentMethodTranslationWrittenEvent;
use Shopware\Api\Payment\Repository\PaymentMethodTranslationRepository;
use Shopware\Api\Payment\Struct\PaymentMethodTranslationBasicStruct;
use Shopware\Api\Payment\Struct\PaymentMethodTranslationDetailStruct;
use Shopware\Api\Shop\Definition\ShopDefinition;
use Shopware\Api\Entity\Field\VersionField;
class PaymentMethodTranslationDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'payment_method_translation';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([ 
            new VersionField(),
            (new FkField('payment_method_id', 'paymentMethodId', PaymentMethodDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new FkField('language_id', 'languageId', ShopDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('name', 'name'))->setFlags(new Required()),
            (new LongTextField('additional_description', 'additionalDescription'))->setFlags(new Required()),
            new ManyToOneAssociationField('paymentMethod', 'payment_method_id', PaymentMethodDefinition::class, false),
            new ManyToOneAssociationField('language', 'language_id', ShopDefinition::class, false),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return PaymentMethodTranslationRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return PaymentMethodTranslationBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return PaymentMethodTranslationDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return PaymentMethodTranslationWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return PaymentMethodTranslationBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDetailStructClass(): string
    {
        return PaymentMethodTranslationDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return PaymentMethodTranslationDetailCollection::class;
    }
}
