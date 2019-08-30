const system_value = 1
const role_config = [
  {
    value: system_value,
    label: 'system',
    index: '/overview'
  },
  {
    value: 3,
    label: 'MerSystem',
    index: '/shops'
  },
  {
    value: 3,
    label: 'fe',
    index: '/placards'
  },
  {
    value: 4,
    label: 're',
    index: '/placards'
  }
]

export const toRoles = roleNames => {
  let roles = roleNames.map(name => {
    const rule = role_config.find(item => item.label === name)
    return rule ? rule.value : null
  })
  roles = roles.filter(item => item)
  return roles.length ? roles : null
}

export const findRoleHome = role_id => {
  const res = role_config.find(item => {
    return item.value === role_id
  })
  return res ? res.index : '/error/404'
}

export const hasPermission = (role_id, route) => {
  const isSystem = role_id === system_value
  if (isSystem) {
    return true
  }
  if (route.meta && route.meta.roles) {
    return route.meta.roles.includes(role_id)
  } else {
    return true
  }
}
