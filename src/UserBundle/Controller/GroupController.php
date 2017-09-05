<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Group;
use UserBundle\Form\Type\GroupType;

/**
 * Group controller.
 *
 * @Route("/admin/group")
 */
class GroupController extends Controller
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="admin_group")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('UserBundle:Group')->findAll();
        
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="admin_group_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Group $group)
    {
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_group_delete');

        return array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="admin_group_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $group = new Group('new', array('test'));
//        $form = $this->createForm(new GroupType(), $group);
        $form = $this->get('form.factory')->create(GroupType::class, $group);
        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/create", name="admin_group_create")
     * @Method("POST")
     * @Template("UserBundle:Group:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $group = new Group();
        $form = $this->get('form.factory')->create(GroupType::class, $group);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_group_show', array('id' => $group->getId())));
        }

        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="admin_group_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Group $group)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_group_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/update", name="admin_group_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("UserBundle:Group:edit.html.twig")
     */
    public function updateAction(Group $group, Request $request)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_group_edit', array('id' => $group->getId())));
        }
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_group_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}/delete", name="admin_group_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Group $group, Request $request)
    {
        $form = $this->createDeleteForm($group->getId(), 'admin_group_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_group'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
