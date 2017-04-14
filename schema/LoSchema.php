<?php

namespace go1\util\schema;

use Doctrine\DBAL\Schema\Schema;

class LoSchema
{
    public static function install(Schema $schema)
    {
        if (!$schema->hasTable('gc_lo')) {
            $lo = $schema->createTable('gc_lo');
            $lo->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
            $lo->addColumn('type', 'string');
            $lo->addColumn('language', 'string');
            $lo->addColumn('instance_id', 'integer', ['unsigned' => true]);
            $lo->addColumn('remote_id', 'integer');
            $lo->addColumn('origin_id', 'integer');
            $lo->addColumn('title', 'string');
            $lo->addColumn('description', 'text');
            $lo->addColumn('private', 'smallint');
            $lo->addColumn('published', 'smallint');
            $lo->addColumn('marketplace', 'smallint');
            $lo->addColumn('image', 'string', ['notnull' => false]);
            $lo->addColumn('event', 'text', ['notnull' => false]);
            $lo->addColumn('event_start', 'integer', ['unsigned' => true, 'notnull' => false]);
            $lo->addColumn('locale', 'string', ['notnull' => false]);
            $lo->addColumn('tags', 'string');
            $lo->addColumn('timestamp', 'integer', ['unsigned' => true]);
            $lo->addColumn('data', 'blob');
            $lo->addColumn('created', 'integer');
            $lo->addColumn('updated', 'integer', ['notnull' => false]);
            $lo->addColumn('sharing', 'smallint');

            $lo->setPrimaryKey(['id']);
            $lo->addIndex(['type']);
            $lo->addIndex(['instance_id']);
            $lo->addIndex(['title']);
            $lo->addIndex(['language']);
            $lo->addIndex(['private']);
            $lo->addIndex(['published']);
            $lo->addIndex(['marketplace']);
            $lo->addIndex(['event_start']);
            $lo->addIndex(['timestamp']);
            $lo->addIndex(['created']);
            $lo->addIndex(['updated']);
            $lo->addIndex(['sharing']);
            $lo->addIndex(['tags']);
            $lo->addIndex(['locale']);
            $lo->addUniqueIndex(['instance_id', 'type', 'remote_id']);
        }

        if (!$schema->hasTable('gc_lo_pricing')) {
            $price = $schema->createTable('gc_lo_pricing');
            $price->addColumn('id', 'integer', ['unsigned' => true]);
            $price->addColumn('price', 'float');
            $price->addColumn('currency', 'string', ['length' => 4]);
            $price->addColumn('tax', 'float');
            $price->addColumn('tax_included', 'smallint', ['default' => 1]);
            $price->setPrimaryKey(['id']);
            $price->addIndex(['price']);
        }

        if (!$schema->hasTable('gc_lo_group')) {
            $group = $schema->createTable('gc_lo_group');
            $group->addColumn('lo_id', 'integer', ['unsigned' => true]);
            $group->addColumn('instance_id', 'integer', ['unsigned' => true]);
            $group->setPrimaryKey(['lo_id', 'instance_id']);
            $group->addIndex(['lo_id']);
            $group->addIndex(['instance_id']);
            $group->addForeignKeyConstraint('gc_lo', ['lo_id'], ['id']);
            $group->addForeignKeyConstraint('gc_instance', ['instance_id'], ['id']);
        }

        if (!$schema->hasTable('gc_event')) {
            $event = $schema->createTable('gc_event');
            $event->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
            $event->addColumn('start', 'string');
            $event->addColumn('end', 'string', ['notnull' => false]);
            $event->addColumn('timezone', 'string', ['length' => 3]);
            $event->addColumn('seats', 'integer', ['notnull' => false]);
            $event->addColumn('available_seats', 'integer', ['notnull' => false]);
            $event->addColumn('loc_country', 'string', ['notnull' => false]);
            $event->addColumn('loc_administrative_area', 'string', ['notnull' => false]);
            $event->addColumn('loc_sub_administrative_area', 'string', ['notnull' => false]);
            $event->addColumn('loc_locality', 'string', ['notnull' => false]);
            $event->addColumn('loc_dependent_locality', 'string', ['notnull' => false]);
            $event->addColumn('loc_thoroughfare', 'string', ['notnull' => false]);
            $event->addColumn('loc_premise', 'string', ['notnull' => false]);
            $event->addColumn('loc_sub_premise', 'string', ['notnull' => false]);
            $event->addColumn('loc_organisation_name', 'string', ['notnull' => false]);
            $event->addColumn('loc_name_line', 'string', ['notnull' => false]);
            $event->addColumn('loc_postal_code', 'integer', ['notnull' => false]);
            $event->addColumn('created', 'integer');
            $event->addColumn('updated', 'integer');
            $event->addColumn('data', 'blob');

            $event->setPrimaryKey(['id']);
            $event->addIndex(['start']);
            $event->addIndex(['end']);
            $event->addIndex(['loc_country']);
            $event->addIndex(['loc_administrative_area']);
            $event->addIndex(['loc_sub_administrative_area']);
            $event->addIndex(['loc_locality']);
            $event->addIndex(['loc_dependent_locality']);
            $event->addIndex(['loc_thoroughfare']);
            $event->addIndex(['loc_premise']);
            $event->addIndex(['loc_sub_premise']);
            $event->addIndex(['loc_organisation_name']);
            $event->addIndex(['loc_name_line']);
            $event->addIndex(['loc_postal_code']);
            $event->addIndex(['created']);
            $event->addIndex(['updated']);
        }

        # @TODO Remove children & lo_count columns.
        if (!$schema->hasTable('gc_tag')) {
            $tag = $schema->createTable('gc_tag');
            $tag->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
            $tag->addColumn('title', 'string');
            $tag->addColumn('instance_id', 'integer', ['unsigned' => true]);
            $tag->addColumn('parent_id', 'integer', ['unsigned' => true]);
            $tag->addColumn('children', 'text', ['description' => 'Children IDs, separated by comma.', 'notnull' => false]);
            $tag->addColumn('lo_count', 'integer', ['default' => 0, 'description' => '@TODO: We do not really need this.']);
            $tag->addColumn('weight', 'integer', ['default' => 0]);
            $tag->addColumn('timestamp', 'integer', ['unsigned' => true]);
            $tag->setPrimaryKey(['id']);
            $tag->addUniqueIndex(['instance_id', 'title']);
            $tag->addIndex(['instance_id']);
            $tag->addIndex(['parent_id']);
            $tag->addIndex(['weight']);
            $tag->addIndex(['timestamp']);
            $tag->addForeignKeyConstraint('gc_instance', ['instance_id'], ['id']);
        }
    }
}