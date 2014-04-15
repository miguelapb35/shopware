<?php

namespace Shopware\Gateway\DBAL;

use Shopware\Components\Model\ModelManager;
use Shopware\Struct\Area;
use Shopware\Struct\State;

class Country implements \Shopware\Gateway\Country
{
    /**
     * @var \Shopware\Components\Model\ModelManager
     */
    private $entityManager;


    private $countryHydrator;

    /**
     * @var array
     */
    private $attributeFields = array();

    /**
     * @param ModelManager $entityManager
     * @param \Shopware\Hydrator\DBAL\Country $countryHydrator
     */
    function __construct(
        ModelManager $entityManager,
        \Shopware\Hydrator\DBAL\Country $countryHydrator
    )
    {
        $this->entityManager = $entityManager;
        $this->countryHydrator = $countryHydrator;
    }


    public function getArea($id)
    {
        $query = $this->entityManager->getDBALQueryBuilder();
        $query->select($this->getAreaFields());
        $query->from('s_core_countries_areas', 'area');
        $query->where('area.id = :id')
            ->setParameter(':id', $id);

        /**@var $statement \Doctrine\DBAL\Driver\ResultStatement */
        $statement = $query->execute();

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        return $this->countryHydrator->hydrateArea($data);
    }

    public function getCountry($id)
    {
        $query = $this->entityManager->getDBALQueryBuilder();
        $query->select($this->getCountryFields())
            ->addSelect($this->getTableFields('s_core_countries_attributes', 'attribute'));

        $query->from('s_core_countries', 'country')
            ->leftJoin('country', 's_core_countries_attributes', 'attribute', 'attribute.countryID = country.id');

        $query->where('country.id = :id')
            ->setParameter(':id', $id);

        /**@var $statement \Doctrine\DBAL\Driver\ResultStatement */
        $statement = $query->execute();

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        return $this->countryHydrator->hydrateCountry($data);
    }

    public function getState($id)
    {
        $query = $this->entityManager->getDBALQueryBuilder();
        $query->select($this->getStateFields())
            ->addSelect($this->getTableFields('s_core_countries_states_attributes', 'attribute'));

        $query->from('s_core_countries_states', 'state')
            ->leftJoin('state', 's_core_countries_states_attributes', 'attribute', 'attribute.stateID = state.id');

        $query->where('state.id = :id')
            ->setParameter(':id', $id);

        /**@var $statement \Doctrine\DBAL\Driver\ResultStatement */
        $statement = $query->execute();

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        return $this->countryHydrator->hydrateState($data);
    }

    private function getAreaFields()
    {
        return array(
            'area.id',
            'area.name',
            'area.active'
        );
    }

    private function getCountryFields()
    {
        return array(
            'country.id',
            'country.countryname',
            'country.countryiso',
            'country.areaID',
            'country.countryen',
            'country.position',
            'country.notice',
            'country.shippingfree',
            'country.taxfree',
            'country.taxfree_ustid',
            'country.taxfree_ustid_checked',
            'country.active',
            'country.iso3',
            'country.display_state_in_registration',
            'country.force_state_in_registration'
        );
    }

    private function getStateFields()
    {
        return array(
            'state.id',
            'state.countryID',
            'state.name',
            'state.shortcode',
            'state.position',
            'state.active'
        );
    }

    /**
     * Helper function which generates an array with table column selections
     * for the passed table.
     *
     * @param $table
     * @param $alias
     * @return array
     */
    private function getTableFields($table, $alias)
    {
        $key = $table . '_' . $alias;

        if ($this->attributeFields[$key] !== null) {
            return $this->attributeFields[$key];
        }

        $schemaManager = $this->entityManager->getConnection()->getSchemaManager();

        $tableColumns = $schemaManager->listTableColumns($table);
        $columns = array();

        foreach ($tableColumns as $column) {
            $columns[] = $alias . '.' . $column->getName() . ' as __' . $alias . '_' . $column->getName();
        }

        $this->attributeFields[$key] = $columns;

        return $this->attributeFields[$key];
    }
}