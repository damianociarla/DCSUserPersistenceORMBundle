# DCSUserPersistenceORMBundle

The **DCSUserPersistenceORMBundle** provides the final implementation of the persistence through *DoctrineORM*.

To do that this bundle will listen to two particular events emitted by *Save* and *Delete* methods of the [DCSUserCoreBundle](https://github.com/damianociarla/DCSUserCoreBundle). The idea at the basis of related packages to *DCS* is to add functionality listening to emitted events.

This bundle provides the implementation of the repository service and performs a mapping of the [User](https://github.com/damianociarla/DCSUserCoreBundle/blob/master/src/Model/User.php) class.

### The repository

The `dcs_user.persistence.orm.repository` service is the implementation of the interface `DCS\User\CoreBundle\Repository\UserRepositoryInterface`. This service can be sets at the **repository_service** parameter in the **dcs_user_core** settings.

    dcs_user_core:
        repository_service: dcs_user.persistence.orm.repository
	

### Events

The complete list of events is within the class `DCS\User\Persistence\ORMBundle\DCSUserPersistenceORMEvents`.

## Installation

### Prerequisites

This bundle requires [DCSUserCoreBundle](https://github.com/damianociarla/DCSUserCoreBundle).

### Require the bundle

Run the following command:

	$ composer require dcs/user-persistence-orm-bundle "~1.0@dev"

Composer will install the bundle to your project's `vendor/dcs/user-persistence-orm-bundle` directory.

### Enable the bundle

Enable the bundle in the kernel:

	<?php
	// app/AppKernel.php

	public function registerBundles()
	{
		$bundles = array(
			// ...
			new DCS\User\Persistence\ORMBundle\DCSUserPersistenceORMBundle(),
			// ...
		);
	}

### Create your User class

You must provide a concrete User class. You must extend the abstract model `DCS\User\CoreBundle\Model\User` provided by the [DCSUserCoreBundle](https://github.com/damianociarla/DCSUserCoreBundle) and create the appropriate mapping.

##### Annotations

    <?php
    // src/AcmeBundle/Entity/User.php

    namespace AcmeBundle\Entity;

    use DCS\User\CoreBundle\Model\User as UserBase;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="dcs_user")
     */
    class User extends UserBase
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
    }

##### Yaml

    # src/AcmeBundle/Resources/config/doctrine/User.orm.yml
	AcmeBundle\Entity\User:
	    type:  entity
	    table: dcs_user
	    id:
	        id:
	            type: integer
	            generator:
	                strategy: AUTO

##### Xml

	<?xml version="1.0" encoding="utf-8"?>
	<!-- src/AcmeBundle/Resources/config/doctrine/User.orm.xml -->
	<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
	                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
	
	    <entity name="AcmeBundle\Entity\User" table="dcs_user">
	        <id name="id" type="integer" column="id">
	            <generator strategy="AUTO"/>
	        </id>
	    </entity>
	</doctrine-mapping>

### Configure

Now that you have properly enabled this bundle, the next step is to configure it.

Add the following configuration to your `config.yml`.

	dcs_user_core:
        model_class: AcmeBundle\Entity\User
        repository_service: dcs_user.persistence.orm.repository
        

