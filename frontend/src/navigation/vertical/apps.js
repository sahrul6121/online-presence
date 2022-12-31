export default [
  {
    header: 'Apps',
  },
  {
    title: 'Todo',
    route: 'apps-todo',
    icon: 'CheckSquareIcon',
  },
  {
    title: 'Calendar',
    route: 'apps-calendar',
    icon: 'CalendarIcon',
  },
  {
    title: 'Role',
    icon: 'UsersIcon',
    children: [
      {
        title: 'List',
        route: 'apps-roles-list',
      },
    ],
  },
  {
    title: 'Employee',
    icon: 'UserIcon',
    children: [
      {
        title: 'List',
        route: 'apps-users-list',
      },
    ],
  },
  {
    title: 'Payroll',
    icon: 'FileTextIcon',
    children: [
      {
        title: 'List',
        route: 'apps-invoice-list',
      },
      {
        title: 'Preview',
        route: { name: 'apps-invoice-preview', params: { id: 4987 } },
      },
      {
        title: 'Edit',
        route: { name: 'apps-invoice-edit', params: { id: 4987 } },
      },
      {
        title: 'Add',
        route: { name: 'apps-invoice-add' },
      },
    ],
  },
  {
   title: 'Setting',
   icon: 'SettingsIcon',
   route: 'apps-settings',
  },
]
