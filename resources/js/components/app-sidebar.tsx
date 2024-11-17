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
                <div className="flex w-fit items-center px-1.5">
                    <div className="flex aspect-square size-5 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                        <Command className="size-3" />
                    </div>
                    <span className="ml-2 truncate font-semibold">Eequate</span>
                </div>
                <NavMain items={data.navMain} />
            </SidebarHeader>
            <SidebarContent>
                <NavSecondary items={data.navSecondary} className="mt-auto" />
            </SidebarContent>
            <SidebarRail />
        </Sidebar>
    );
}
