'use client';

import {
    Blocks,
    Command,
    Home,
    MessageCircleQuestion,
    Search,
    Settings2,
    Sparkles,
} from 'lucide-react';
import * as React from 'react';

import { NavMain } from '@/components/nav-main';
import { NavSecondary } from '@/components/nav-secondary';
import {
    Sidebar,
    SidebarContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarRail,
} from '@/components/ui/sidebar';

// Routes
const data = {
    navMain: [
        {
            title: 'Search',
            url: '#',
            icon: Search,
        },
        {
            title: 'Home',
            url: '#',
            icon: Home,
            isActive: true,
        },
        {
            title: 'Generate Post',
            url: '#',
            icon: Sparkles,
        },
    ],
    navSecondary: [
        {
            title: 'Templates',
            url: '#',
            icon: Blocks,
        },
        {
            title: 'Settings',
            url: '#',
            icon: Settings2,
        },
        {
            title: 'Help',
            url: '#',
            icon: MessageCircleQuestion,
        },
    ],
};

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
    return (
        <Sidebar className="border-r-0" {...props}>
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <a href={route('dashboard')}>
                                <div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                                    <Command className="size-4" />
                                </div>
                                <div className="grid flex-1 text-left text-sm leading-tight">
                                    <span className="truncate font-semibold">
                                        Eequate
                                    </span>
                                    <span className="truncate text-xs">
                                        Enterprise
                                    </span>
                                </div>
                            </a>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
                <NavMain items={data.navMain} />
            </SidebarHeader>
            <SidebarContent>
                <NavSecondary items={data.navSecondary} className="mt-auto" />
            </SidebarContent>
            <SidebarRail />
        </Sidebar>
    );
}
