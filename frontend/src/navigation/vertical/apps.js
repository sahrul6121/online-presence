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
    title: 'Presence',
    route: 'apps-presence',
    icon: 'ClipboardIcon',
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
    ],
  },
  {
    title: 'Setting',
    icon: 'SettingsIcon',
    route: 'apps-settings',
  },
]
